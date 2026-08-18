@extends('customer.layout')
@section('heading', 'My bookings')

@section('panel')
<form class="d-flex gap-2 mb-3">
    <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Booking number or tour" value="{{ request('keyword') }}">
    <select name="status" class="form-select form-select-sm w-auto">
        <option value="">All statuses</option>
        @foreach (\App\Enums\BookingStatus::cases() as $status)
            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
        @endforeach
    </select>
    <button class="btn btn-sm btn-outline-secondary">Filter</button>
</form>

@forelse ($bookings as $booking)
    <article class="border rounded p-3 mb-2">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <div>
                <a class="fw-semibold" href="{{ route('customer.bookings.show', $booking->uuid) }}">{{ $booking->tour?->title }}</a>
                <span class="d-block small text-muted">
                    {{ $booking->booking_number }} · departing {{ $booking->travel_date->format('D d M Y') }}
                    · {{ $booking->total_guests }} guests
                </span>
            </div>
            <div class="text-end">
                <span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span>
                <span class="d-block small">{{ money($booking->grand_total) }}</span>
                @if ($booking->due_amount > 0)
                    <a class="small" href="{{ route('customer.bookings.pay', $booking->uuid) }}">Pay {{ money($booking->due_amount) }}</a>
                @endif
            </div>
        </div>
    </article>
@empty
    <p class="text-muted py-5 text-center">
        No bookings yet. <a href="{{ route('tours.index') }}">Find your first trip</a>.
    </p>
@endforelse

<div class="mt-3">{{ $bookings->withQueryString()->links() }}</div>
@endsection
