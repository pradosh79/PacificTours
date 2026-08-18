<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead><tr>
            <th>Booking</th><th>Customer</th><th>Tour</th><th>Travel date</th>
            <th class="text-end">Total</th><th class="text-end">Due</th><th>Status</th><th>Payment</th><th></th>
        </tr></thead>
        <tbody>
        @forelse ($bookings as $booking)
            <tr>
                <td>
                    <a class="fw-semibold" href="{{ route('admin.bookings.show', $booking->uuid) }}">{{ $booking->booking_number }}</a>
                    <span class="d-block small text-muted">{{ $booking->created_at->format('d M Y') }}</span>
                </td>
                <td>
                    {{ $booking->customer_name }}
                    <span class="d-block small text-muted">{{ $booking->customer_email }}</span>
                </td>
                <td class="text-truncate" style="max-width:14rem">{{ $booking->tour?->title }}</td>
                <td>{{ $booking->travel_date->format('d M Y') }}</td>
                <td class="text-end">{{ money($booking->grand_total) }}</td>
                <td class="text-end {{ $booking->due_amount > 0 ? 'text-danger' : '' }}">{{ money($booking->due_amount) }}</td>
                <td><span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span></td>
                <td><span class="badge text-bg-light">{{ Str::headline($booking->payment_status->value) }}</span></td>
                <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.bookings.show', $booking->uuid) }}">Open</a></td>
            </tr>
        @empty
            <tr><td colspan="9" class="text-center text-muted py-5">No bookings match this filter.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="panel-foot">{{ $bookings->links() }}</div>
