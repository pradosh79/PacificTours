@extends('layouts.app')
@section('content')
<div class="container py-5 text-center" style="max-width:560px">
    <h1 class="h4">Payment wasn't completed</h1>
    <p class="text-muted">
        Booking <strong>{{ $booking->booking_number }}</strong> is still held for you, unpaid.
        You can finish paying now, or it will be released automatically.
    </p>
    <div class="d-flex gap-2 justify-content-center mt-4">
        <a class="btn btn-primary" href="{{ route('checkout.pay', $booking->uuid) }}">Try payment again</a>
        <a class="btn btn-outline-secondary" href="{{ route('tours.show', $booking->tour->slug) }}">Back to the tour</a>
    </div>
</div>
@endsection
