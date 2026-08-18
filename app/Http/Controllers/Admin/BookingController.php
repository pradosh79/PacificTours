<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\BookingData;
use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Tour;
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
    ) {
        $this->authorizeResource(Booking::class, 'booking');
    }

    public function index(Request $request)
    {
        $bookings = $this->bookings->paginate(
            perPage: (int) $request->integer('per_page', 20),
            filters: $request->only(['keyword', 'status', 'payment_status', 'tour_id', 'date_from', 'date_to', 'travel_from', 'travel_to']),
            relations: ['tour:id,title', 'user:id,first_name,last_name'],
        );

        return $request->ajax()
            ? view('admin.bookings.partials.table', compact('bookings'))->render()
            : view('admin.bookings.index', [
                'bookings' => $bookings,
                'statuses' => BookingStatus::cases(),
                'tours'    => Tour::orderBy('title')->get(['id', 'title']),
            ]);
    }

    public function create()
    {
        return view('admin.bookings.form', ['tours' => Tour::published()->get(['id', 'title', 'base_price'])]);
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->service->create(BookingData::fromArray($request->validated()));

        return redirect()->route('admin.bookings.show', $booking->uuid)
            ->with('success', "Booking {$booking->booking_number} created.");
    }

    public function show(Booking $booking)
    {
        $booking->load(['tour', 'departure', 'travelers', 'payments.refunds', 'invoice', 'statusHistories.user', 'coupon']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $this->authorize('confirm', $booking);
        $this->service->confirm($booking, request('note'));

        return back()->with('success', 'Booking confirmed.');
    }

    public function complete(Booking $booking)
    {
        $this->authorize('update', $booking);
        $this->service->complete($booking, request('note'));

        return back()->with('success', 'Booking marked complete.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('cancel', $booking);

        $request->validate(['reason' => ['required', 'string', 'max:255']]);
        $this->service->cancel($booking, $request->string('reason')->toString());

        return back()->with('success', 'Booking cancelled and seats released.');
    }

    /** Records a cash / e-transfer payment taken at the office. */
    public function recordPayment(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $data = $request->validate([
            'amount'  => ['required', 'numeric', 'min:0.01', 'max:'.$booking->due_amount],
            'gateway' => ['required', 'in:manual,cash,bank_transfer'],
            'note'    => ['nullable', 'string', 'max:255'],
        ]);

        $this->payments->recordManual($booking, (float) $data['amount'], $data['gateway'], $data['note'] ?? null);

        return back()->with('success', 'Payment recorded.');
    }

    public function updateNote(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $booking->update($request->validate(['admin_note' => ['nullable', 'string', 'max:2000']]));

        return $this->ok(message: 'Note saved.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted.');
    }
}
