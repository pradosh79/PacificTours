import Alpine from 'alpinejs';
import * as bootstrap from 'bootstrap';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.bootstrap = bootstrap;

const csrf = () => document.querySelector('meta[name="csrf-token"]').content;

const request = async (url, options = {}) => {
    const response = await fetch(url, {
        headers: {
            'X-CSRF-TOKEN': csrf(),
            'X-Requested-With': 'XMLHttpRequest',
            Accept: 'application/json',
            ...(options.body instanceof FormData ? {} : { 'Content-Type': 'application/json' }),
        },
        ...options,
    });

    if (!response.ok) {
        throw new Error((await response.json().catch(() => ({}))).message ?? 'Something went wrong.');
    }

    return response.json();
};

/**
 * Server-rendered table with AJAX filtering, pagination and bulk actions.
 * Markup stays in Blade so a designer can restyle it without touching JS.
 */
Alpine.data('dataTable', (indexUrl, bulkUrl) => ({
    filters: { keyword: '', status: '' },
    selected: [],
    loading: false,

    async reload(page = 1) {
        this.loading = true;
        const params = new URLSearchParams({ ...this.filters, page });

        const response = await fetch(`${indexUrl}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });

        document.getElementById('table-target').innerHTML = await response.text();
        this.selected = [];
        this.loading = false;
        history.replaceState(null, '', `${indexUrl}?${params}`);
    },

    toggleAll(event) {
        const boxes = document.querySelectorAll('#table-target input[type=checkbox]');
        this.selected = event.target.checked ? [...boxes].map((b) => Number(b.value)).filter(Boolean) : [];
        boxes.forEach((box) => { box.checked = event.target.checked; });
    },

    async bulk(action) {
        if (action === 'delete' && !confirm(`Delete ${this.selected.length} record(s)? This cannot be undone.`)) return;

        const result = await request(bulkUrl, {
            method: 'POST',
            body: JSON.stringify({ action, ids: this.selected }),
        });

        window.notify(result.message);
        this.reload();
    },
}));

Alpine.data('notifications', () => ({
    items: [],
    unread: 0,

    async load() {
        const { data } = await request('/admin/notifications');
        this.items = data.items;
        this.unread = data.unread;
    },

    async markRead(id) {
        await request(`/admin/notifications/${id}/read`, { method: 'PATCH' });
        this.unread = Math.max(0, this.unread - 1);
    },
}));

window.notify = (message, variant = 'success') => {
    const el = document.createElement('div');
    el.className = `toast align-items-center text-bg-${variant} show position-fixed bottom-0 end-0 m-3`;
    el.role = 'status';
    el.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div></div>`;
    document.body.append(el);
    setTimeout(() => el.remove(), 4000);
};

// Dashboard chart -----------------------------------------------------------
const canvas = document.getElementById('chart-revenue');

if (canvas) {
    const revenue = JSON.parse(canvas.dataset.revenue);
    const bookings = JSON.parse(canvas.dataset.bookings);

    new Chart(canvas, {
        data: {
            labels: Object.keys(revenue),
            datasets: [
                { type: 'bar', label: 'Revenue', data: Object.values(revenue), yAxisID: 'y', borderRadius: 4 },
                { type: 'line', label: 'Bookings', data: Object.values(bookings), yAxisID: 'y1', tension: 0.35 },
            ],
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: { position: 'left', ticks: { callback: (v) => `$${v.toLocaleString()}` } },
                y1: { position: 'right', grid: { drawOnChartArea: false } },
            },
        },
    });
}

Alpine.start();
