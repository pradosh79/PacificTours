@component('mail::message')
# You're going, {{ $booking->customer_first_name }}

**{{ $booking->tour->title }}**
{{ $booking->travel_date->format('l, d F Y') }}
Reference **{{ $booking->booking_number }}**

@if ($booking->tour->meeting_point)
**Where to meet:** {{ $booking->tour->meeting_point }}
@endif
@if ($booking->tour->pickup_location)
**Pickup:** {{ $booking->tour->pickup_location }}
@endif

@if ($booking->due_amount > 0)
@component('mail::panel')
Balance of {{ money($booking->due_amount) }} is due before departure.
@endcomponent
@endif

@component('mail::button', ['url' => route('customer.bookings.show', $booking->uuid)])
View your booking
@endcomponent

Your invoice is attached to your account under Invoices.

{{ setting('general.company_name') }}
@endcomponent
