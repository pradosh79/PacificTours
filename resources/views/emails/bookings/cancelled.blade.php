@component('mail::message')
# Booking {{ $booking->booking_number }} is cancelled

**{{ $booking->tour->title }}** on {{ $booking->travel_date->format('d M Y') }} has been cancelled.

@if ($reason)
Reason given: {{ $reason }}
@endif

@if ($booking->paid_amount > 0)
Any refund follows the cancellation policy for this tour. We will email you as soon as it is processed.
@endif

@component('mail::button', ['url' => route('tours.index')])
Browse other departures
@endcomponent
@endcomponent
