@extends('layouts.app')
@section('content')
<div class="container py-5 text-center" style="max-width:640px">
    <h1 class="h3">You're booked, {{ $booking->customer_first_name }}</h1>
    <p class="lead text-muted">Reference <strong>{{ $booking->booking_number }}</strong></p>

    <div class="border rounded p-4 text-start mt-4">
        <h2 class="h6">{{ $booking->tour->title }}</h2>
        <p class="small text-muted mb-3">
            Departing {{ $booking->travel_date->format('l, d F Y') }} ·
            {{ $booking->adults }} adults, {{ $booking->children }} children, {{ $booking->infants }} infants
        </p>
        <dl class="row small mb-0">
            <dt class="col-7">Total</dt><dd class="col-5 text-end">{{ money($booking->grand_total) }}</dd>
            <dt class="col-7 text-success">Paid</dt><dd class="col-5 text-end text-success">{{ money($booking->paid_amount) }}</dd>
            @if ($booking->due_amount > 0)
                <dt class="col-7 text-danger">Balance due</dt><dd class="col-5 text-end text-danger">{{ money($booking->due_amount) }}</dd>
            @endif
        </dl>
    </div>

    <p class="mt-4">A confirmation is on its way to {{ $booking->customer_email }}.</p>

    <div class="d-flex gap-2 justify-content-center mt-4">
        @auth<a class="btn btn-primary" href="{{ route('customer.bookings.show', $booking->uuid) }}">View booking</a>@endauth
        <a class="btn btn-outline-secondary" href="{{ route('tours.index') }}">Browse more tours</a>
    </div>
</div>
@endsection
