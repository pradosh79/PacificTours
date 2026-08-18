@component('mail::message')
# Thanks, {{ $booking->customer_first_name }} — we have your booking

**{{ $booking->tour->title }}**
Departing {{ $booking->travel_date->format('D, d M Y') }}
{{ $booking->adults }} adults · {{ $booking->children }} children · {{ $booking->infants }} infants
Reference **{{ $booking->booking_number }}**

@component('mail::panel')
Total {{ money($booking->grand_total) }} · Due now {{ money($booking->due_amount) }}
@endcomponent

Your seats are held until payment clears. If you left the payment page early you can pick it up here:

@component('mail::button', ['url' => route('checkout.pay', $booking->uuid)])
Complete payment
@endcomponent

Questions? Reply to this email and a trip planner will answer.

{{ setting('general.company_name') }}
@endcomponent
