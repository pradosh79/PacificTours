@extends('layouts.app')
@section('content')
<div class="container py-5 text-center" style="max-width:560px">
    <h1 class="h4">We're still confirming your payment</h1>
    <p class="text-muted">
        Booking <strong>{{ $booking->booking_number }}</strong> is created and your seats are held.
        Some payment methods take a few minutes to clear — we'll email you the moment it does.
    </p>
    <p class="small text-muted">You don't need to pay again. Paying twice would create a second charge.</p>
    <a class="btn btn-outline-secondary mt-3" href="{{ route('home') }}">Back to the homepage</a>
</div>
@endsection
