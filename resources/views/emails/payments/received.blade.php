@component('mail::message')
# Payment received

We received {{ money($payment->amount) }} for booking **{{ $payment->booking->booking_number }}**
via {{ $payment->gateway->label() }} on {{ $payment->paid_at?->format('d M Y H:i') }}.

@if ($payment->booking->due_amount > 0)
Remaining balance: {{ money($payment->booking->due_amount) }}
@else
Your booking is paid in full.
@endif

@component('mail::button', ['url' => route('customer.bookings.show', $payment->booking->uuid)])
View booking
@endcomponent
@endcomponent
