<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\BookingData;
use App\DTOs\PriceBreakdown;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Events\BookingCancelled;
use App\Events\BookingConfirmed;
use App\Events\BookingCreated;
use App\Exceptions\BookingException;
use App\Models\Booking;
use App\Models\Tour;
use App\Support\NumberGenerator;
use Illuminate\Support\Facades\DB;

/**
 * Orchestrates the booking lifecycle. Controllers hand it a DTO and get back a
 * persisted Booking; every seat movement, price freeze and status change goes
 * through one transaction here.
 */
class BookingService
{
    public function __construct(
        private readonly PricingService $pricing,
        private readonly AvailabilityService $availability,
        private readonly CouponService $coupons,
        private readonly InvoiceService $invoices,
    ) {}

    /**
     * Creates a pending booking and holds inventory.
     *
     * @throws BookingException
     */
    public function create(BookingData $data): Booking
    {
        return DB::transaction(function () use ($data): Booking {
            $tour      = Tour::whereKey($data->tourId)->firstOrFail();
            $departure = $this->availability->lockDeparture($data->departureId);

            $this->availability->assertBookable($tour, $departure, $data->travelDate, $data->seatCount());

            $quote = $this->pricing->quote($tour, $data, $departure);

            $booking = Booking::create(array_merge(
                $data->toBookingColumns(),
                $quote->toBookingColumns(),
                [
                    'booking_number' => NumberGenerator::booking(),
                    'return_date'    => $this->returnDate($tour, $data->travelDate),
                    'status'         => BookingStatus::Pending,
                    'payment_status' => PaymentStatus::Unpaid,
                    'created_by'     => auth()->id(),
                ]
            ));

            $this->syncTravelers($booking, $data);

            if ($quote->couponId) {
                $this->coupons->redeem($booking->coupon()->first(), $booking, $quote->couponDiscount);
            }

            $this->availability->holdSeats($departure, $data->seatCount());
            $tour->increment('bookings_count');

            $this->recordStatus($booking, null, BookingStatus::Pending, 'Booking created');
            $this->invoices->createFor($booking);

            BookingCreated::dispatch($booking->fresh(['tour', 'travelers', 'invoice']));

            return $booking->refresh();
        }, 3);
    }

    /** Re-quotes without persisting: used by the wizard's live price panel and the API. */
    public function quote(BookingData $data): PriceBreakdown
    {
        $tour      = Tour::whereKey($data->tourId)->firstOrFail();
        $departure = $data->departureId ? $tour->departures()->whereKey($data->departureId)->first() : null;

        return $this->pricing->quote($tour, $data, $departure);
    }

    public function confirm(Booking $booking, ?string $note = null): Booking
    {
        return $this->transitionTo($booking, BookingStatus::Confirmed, $note, function (Booking $b): void {
            $b->forceFill(['confirmed_at' => now()])->save();
            BookingConfirmed::dispatch($b);
        });
    }

    public function complete(Booking $booking, ?string $note = null): Booking
    {
        return $this->transitionTo($booking, BookingStatus::Completed, $note, function (Booking $b): void {
            $b->forceFill(['completed_at' => now()])->save();
        });
    }

    public function cancel(Booking $booking, ?string $reason = null): Booking
    {
        return DB::transaction(function () use ($booking, $reason): Booking {
            $booking = $this->transitionTo($booking, BookingStatus::Cancelled, $reason, function (Booking $b) use ($reason): void {
                $b->forceFill(['cancelled_at' => now(), 'cancellation_reason' => $reason])->save();
            });

            $this->availability->releaseSeats($booking->departure, $booking->seatCount());
            $this->coupons->release($booking);
            $booking->tour?->decrement('bookings_count');

            BookingCancelled::dispatch($booking, $reason);

            return $booking;
        });
    }

    /** Recomputes paid/due/payment_status from the ledger — never trust an incoming amount. */
    public function syncPaymentTotals(Booking $booking): Booking
    {
        $paid     = (float) $booking->successfulPayments()->sum('amount');
        $refunded = (float) $booking->refunds()->where('status', 'completed')->sum('amount');
        $due      = round((float) $booking->grand_total - $paid + $refunded, 2);

        $status = match (true) {
            $refunded > 0 && $refunded >= $paid                 => PaymentStatus::Refunded,
            $refunded > 0                                       => PaymentStatus::PartiallyRefunded,
            $due <= 0.009                                       => PaymentStatus::Paid,
            $paid > 0 && $paid >= (float) $booking->deposit_amount && $booking->deposit_amount > 0
                                                                => PaymentStatus::DepositPaid,
            $paid > 0                                           => PaymentStatus::PartiallyPaid,
            default                                             => PaymentStatus::Unpaid,
        };

        $booking->forceFill([
            'paid_amount'     => $paid,
            'refunded_amount' => $refunded,
            'due_amount'      => max(0, $due),
            'payment_status'  => $status,
        ])->save();

        $booking->invoice?->update([
            'amount_paid' => $paid,
            'status'      => $due <= 0.009 ? 'paid' : ($paid > 0 ? 'partial' : 'unpaid'),
        ]);

        return $booking;
    }

    private function transitionTo(Booking $booking, BookingStatus $target, ?string $note, ?callable $after = null): Booking
    {
        $current = $booking->status;

        if (! $current->canTransitionTo($target)) {
            throw BookingException::invalidTransition($current->value, $target->value);
        }

        $booking->forceFill(['status' => $target])->save();
        $this->recordStatus($booking, $current, $target, $note);

        if ($after) {
            $after($booking);
        }

        return $booking->refresh();
    }

    private function recordStatus(Booking $booking, ?BookingStatus $from, BookingStatus $to, ?string $note): void
    {
        $booking->statusHistories()->create([
            'from_status' => $from?->value,
            'to_status'   => $to->value,
            'changed_by'  => auth()->id(),
            'note'        => $note,
        ]);
    }

    private function syncTravelers(Booking $booking, BookingData $data): void
    {
        foreach ($data->travelers as $traveler) {
            $booking->travelers()->create($traveler->toModelArray());
        }

        // Lead traveller falls back to the buyer when the wizard skips the manifest step.
        if ($booking->travelers()->count() === 0) {
            $booking->travelers()->create([
                'type'       => 'adult',
                'first_name' => $data->customerFirstName,
                'last_name'  => $data->customerLastName,
            ]);
        }
    }

    private function returnDate(Tour $tour, string $travelDate): string
    {
        return now()->parse($travelDate)->addDays(max(0, $tour->duration_days - 1))->toDateString();
    }
}
