@component('mail::message')
# Your trip is nearly here

**{{ $booking->tour->title }}** departs {{ $booking->travel_date->format('l, d F') }}.

@if ($booking->tour->meeting_point)
**Meeting point:** {{ $booking->tour->meeting_point }}
@endif

Bring photo ID, and dress for coastal weather — layers and a rain shell.

@component('mail::button', ['url' => route('customer.bookings.show', $booking->uuid)])
Trip details
@endcomponent
@endcomponent
