<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\DTOs\BookingData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\BookingWizardRequest;
use App\Http\Resources\PriceQuoteResource;
use App\Models\Tour;
use App\Services\BookingService;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Http\Request;

/**
 * Five-step wizard. State lives in the session between steps, so a page refresh
 * never loses the customer's progress, and the final POST re-validates
 * everything server side.
 */
class BookingWizardController extends Controller
{
    private const SESSION_KEY = 'booking.wizard';

    public function __construct(
        private readonly BookingService $bookings,
        private readonly PaymentGatewayManager $gateways,
    ) {}

    /** Step 1–2: tour + date chosen on the tour page, wizard opens at step 3. */
    public function start(Request $request, string $slug)
    {
        $tour = Tour::published()->where('slug', $slug)->firstOrFail();

        $state = array_merge(session(self::SESSION_KEY, []), $request->only([
            'tour_departure_id', 'travel_date', 'adults', 'children', 'infants',
        ]), ['tour_id' => $tour->id]);

        session([self::SESSION_KEY => $state]);

        return view('web.booking.wizard', [
            'tour'       => $tour->load(['departures' => fn ($q) => $q->open()->orderBy('start_date')]),
            'state'      => $state,
            'gateways'   => $this->gateways->enabled(),
            'step'       => (int) $request->integer('step', 1),
        ]);
    }

    /** Live quote for the sticky price panel — called on every wizard change. */
    public function quote(Request $request)
    {
        $data = $request->validate([
            'tour_id'           => ['required', 'exists:tours,id'],
            'tour_departure_id' => ['nullable', 'exists:tour_departures,id'],
            'travel_date'       => ['required', 'date'],
            'adults'            => ['required', 'integer', 'min:1'],
            'children'          => ['nullable', 'integer', 'min:0'],
            'infants'           => ['nullable', 'integer', 'min:0'],
            'coupon_code'       => ['nullable', 'string', 'max:40'],
            'pay_deposit'       => ['boolean'],
        ]);

        try {
            $quote = $this->bookings->quote(BookingData::fromArray($data + [
                'customer_first_name' => 'quote',
                'customer_email'      => $request->user()?->email ?? 'quote@example.com',
                'customer_last_name'  => null,
                'customer_phone'      => null,
                'user_id'             => $request->user()?->id,
            ]));

            return $this->ok(new PriceQuoteResource($quote));
        } catch (\App\Exceptions\CouponException $e) {
            return $this->fail($e->getMessage(), 422);
        }
    }

    /** Step 5: create the booking, then hand off to the payment gateway. */
    public function store(BookingWizardRequest $request)
    {
        try {
            $booking = $this->bookings->create(BookingData::fromArray($request->validated()));
        } catch (\App\Exceptions\BookingException|\App\Exceptions\CouponException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        session()->forget(self::SESSION_KEY);

        return redirect()->route('checkout.pay', [
            'booking' => $booking->uuid,
            'gateway' => $request->string('gateway')->toString(),
        ]);
    }
}
