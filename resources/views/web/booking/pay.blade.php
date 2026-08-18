@extends('layouts.app')
@section('content')
<div class="container py-5" style="max-width:560px">
    <h1 class="h4">Complete your payment</h1>
    <p class="text-muted">Booking {{ $booking->booking_number }} · {{ $booking->tour->title }}</p>

    <div class="border rounded p-4">
        <p class="h5">{{ money($result->amount ?? $booking->due_amount) }} due now</p>

        @if ($result->requiresRedirect())
            <a class="btn btn-primary w-100" href="{{ $result->redirectUrl }}">Continue to the payment page</a>
        @else
            {{-- Manual / bank transfer: show instructions rather than a redirect --}}
            <div class="small">{!! $result->instructions ?? setting('payment.manual_instructions') !!}</div>
            <p class="small text-muted mt-3">
                Quote reference <strong>{{ $booking->booking_number }}</strong> with your transfer.
                We confirm your seats once the funds arrive.
            </p>
        @endif
    </div>

    <p class="small text-muted mt-3">
        Payments are processed by our payment provider. We never see or store your card details.
    </p>
</div>
@endsection
