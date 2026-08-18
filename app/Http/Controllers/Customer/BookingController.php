<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Services\BookingService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookings,
        private readonly BookingService $service,
        private readonly PaymentService $payments,
    ) {}

    public function index(Request $request)
    {
        return view('customer.bookings.index', [
            'bookings' => $this->bookings->forUser($request->user()->id, $request->only(['status', 'keyword'])),
        ]);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        $booking->load(['tour', 'travelers', 'payments', 'invoice', 'departure']);

        return view('customer.bookings.show', compact('booking'));
    }

    /** Pay the outstanding balance from the customer portal. */
    public function pay(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);
        abort_if($booking->isFullyPaid(), 409, 'Nothing left to pay on this booking.');

        $result = $this->payments->initiate(
            $booking,
            $request->string('gateway', 'stripe')->toString(),
            PaymentType::Balance
        );

        return $result->requiresRedirect()
            ? redirect()->away($result->redirectUrl)
            : view('web.booking.pay', compact('booking', 'result'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('cancel', $booking);

        $request->validate(['reason' => ['required', 'string', 'max:255']]);

        $this->service->cancel($booking, 'Customer request: '.$request->string('reason'));

        return back()->with('success', 'Your booking has been cancelled. Any refund follows the cancellation policy for this tour.');
    }
}
