import Alpine from 'alpinejs';
import * as bootstrap from 'bootstrap';

window.Alpine = Alpine;
window.bootstrap = bootstrap;

const csrf = () => document.querySelector('meta[name="csrf-token"]').content;

/**
 * Booking wizard. Step state is local; every price comes from the server so the
 * customer can never see a total the backend would not charge.
 */
Alpine.data('bookingWizard', ({ step, tourId, quoteUrl, state }) => ({
    step,
    submitting: false,
    couponError: '',
    quote: { lines: [], subtotal: 0, tour_discount: 0, tax: 0, total: 0, deposit: 0, payable_now: 0, currency: 'CAD' },

    form: {
        tour_id: tourId,
        tour_departure_id: state.tour_departure_id ?? null,
        travel_date: state.travel_date ?? new Date().toISOString().slice(0, 10),
        adults: Number(state.adults ?? 1),
        children: Number(state.children ?? 0),
        infants: Number(state.infants ?? 0),
        coupon_code: '',
        pay_deposit: false,
        terms: false,
    },

    init() {
        this.syncDateFromDeparture();
        this.refreshQuote();
    },

    get travellers() {
        return [
            ...Array(this.form.adults).fill({ type: 'adult' }),
            ...Array(this.form.children).fill({ type: 'child' }),
            ...Array(this.form.infants).fill({ type: 'infant' }),
        ];
    },

    syncDateFromDeparture() {
        const option = document.querySelector(`option[value="${this.form.tour_departure_id}"]`);
        if (option?.dataset.date) this.form.travel_date = option.dataset.date;
    },

    next() {
        if (this.step === 2) this.syncDateFromDeparture();
        this.step = Math.min(5, this.step + 1);
        this.refreshQuote();
    },

    back() {
        this.step = Math.max(1, this.step - 1);
    },

    async refreshQuote() {
        this.couponError = '';

        const response = await fetch(quoteUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf(),
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            body: JSON.stringify(this.form),
        });

        const payload = await response.json();

        if (!response.ok) {
            this.couponError = payload.message ?? 'We could not price that combination.';
            return;
        }

        this.quote = payload.data;
    },

    format(amount) {
        return new Intl.NumberFormat('en-CA', { style: 'currency', currency: this.quote.currency ?? 'CAD' })
            .format(amount ?? 0);
    },
}));

// Wishlist toggle -----------------------------------------------------------
document.querySelectorAll('[data-wishlist]').forEach((button) => {
    button.addEventListener('click', async () => {
        const response = await fetch(button.dataset.wishlist, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf(), Accept: 'application/json' },
        });
        const payload = await response.json();
        button.textContent = payload.data.saved ? 'Saved' : 'Save for later';
    });
});

Alpine.start();
