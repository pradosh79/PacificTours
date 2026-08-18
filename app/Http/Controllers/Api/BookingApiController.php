<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTOs\BookingData;
use App\Exceptions\BookingException;
use App\Exceptions\CouponException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiBookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\PriceQuoteResource;
use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    public function __construct(
        private readonly BookingService $bookings,
        private readonly BookingRepositoryInterface $repository,
    ) {}

    public function index(Request $request)
    {
        return BookingResource::collection(
            $this->repository->forUser($request->user()->id, $request->all(), (int) $request->integer('per_page', 10))
        );
    }

    public function show(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        return new BookingResource($booking->load(['tour', 'travelers', 'payments', 'invoice']));
    }

    public function quote(ApiBookingRequest $request)
    {
        try {
            return $this->ok(new PriceQuoteResource($this->bookings->quote(BookingData::fromArray($request->validated()))));
        } catch (CouponException $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function store(ApiBookingRequest $request)
    {
        try {
            $booking = $this->bookings->create(BookingData::fromArray($request->validated() + ['source' => 'api']));
        } catch (BookingException|CouponException $e) {
            return $this->fail($e->getMessage(), 409);
        }

        return $this->ok(new BookingResource($booking->load(['tour', 'invoice'])), 'Booking created.', 201);
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('cancel', $booking);

        $this->bookings->cancel($booking, $request->input('reason', 'Cancelled via API'));

        return $this->ok(new BookingResource($booking->fresh()), 'Booking cancelled.');
    }
}
