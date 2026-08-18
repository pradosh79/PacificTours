<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private readonly PaymentService $payments) {}

    public function pay(Request $request, Booking $booking)
    {
        abort_if($booking->isFullyPaid(), 409, 'This booking is already paid.');

        $gateway = $request->string('gateway', 'stripe')->toString();
        $type    = $booking->deposit_amount > 0 && $booking->paid_amount == 0
            ? PaymentType::Deposit
            : PaymentType::Balance;

        try {
            $result = $this->payments->initiate($booking, $gateway, $type);
        } catch (\App\Exceptions\PaymentException $e) {
            return redirect()->route('checkout.cancel', $booking->uuid)->with('error', $e->getMessage());
        }

        return $result->requiresRedirect()
            ? redirect()->away($result->redirectUrl)
            : view('web.booking.pay', compact('booking', 'result'));
    }

    /** Gateway return URL. Settling is idempotent, so refreshing is harmless. */
    public function success(Request $request, Booking $booking)
    {
        $gateway = $request->filled('session_id') ? 'stripe' : 'paypal';

        try {
            $this->payments->settle($booking, $gateway, $request->all());
        } catch (\Throwable $e) {
            report($e);

            return view('web.booking.pending', compact('booking'));
        }

        return view('web.booking.success', ['booking' => $booking->fresh(['tour', 'invoice', 'payments'])]);
    }

    public function cancel(Booking $booking)
    {
        return view('web.booking.cancelled', compact('booking'));
    }

    /** Public lookup for guest checkout: booking number + email. */
    public function lookup(Request $request)
    {
        $data = $request->validate([
            'booking_number' => ['required', 'string'],
            'email'          => ['required', 'email'],
        ]);

        $booking = Booking::where('booking_number', $data['booking_number'])
            ->where('customer_email', $data['email'])
            ->with(['tour', 'payments', 'invoice'])
            ->first();

        return $booking
            ? view('web.booking.status', compact('booking'))
            : back()->with('error', 'We could not find a booking with those details.');
    }
}
