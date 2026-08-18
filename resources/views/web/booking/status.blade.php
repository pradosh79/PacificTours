@extends('layouts.app')
@section('content')
<div class="container py-5" style="max-width:720px">
    <h1 class="h4">Booking {{ $booking->booking_number }}</h1>
    <span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span>

    <div class="border rounded p-4 mt-3">
        <h2 class="h6">{{ $booking->tour->title }}</h2>
        <p class="small text-muted">Departing {{ $booking->travel_date->format('l, d F Y') }}</p>
        <dl class="row small mb-0">
            <dt class="col-7">Total</dt><dd class="col-5 text-end">{{ money($booking->grand_total) }}</dd>
            <dt class="col-7">Paid</dt><dd class="col-5 text-end">{{ money($booking->paid_amount) }}</dd>
            <dt class="col-7">Due</dt><dd class="col-5 text-end">{{ money($booking->due_amount) }}</dd>
        </dl>
    </div>

    @if ($booking->due_amount > 0)
        <a class="btn btn-primary mt-3" href="{{ route('checkout.pay', $booking->uuid) }}">Pay {{ money($booking->due_amount) }}</a>
    @endif

    <p class="small text-muted mt-4">
        Need to change something? <a href="{{ route('contact') }}">Contact us</a> and quote your reference.
    </p>
</div>
@endsection
