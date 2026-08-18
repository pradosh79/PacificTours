<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\BookingException;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourDeparture;
use Illuminate\Support\Carbon;

/**
 * Owns seat inventory. Seats live on tour_departures and are only ever moved
 * inside a locked transaction owned by BookingService.
 */
class AvailabilityService
{
    public function assertBookable(Tour $tour, ?TourDeparture $departure, string $travelDate, int $seats): void
    {
        if (! $tour->isBookable()) {
            throw BookingException::tourNotBookable();
        }

        if ($seats < $tour->min_booking || $seats > $tour->max_booking) {
            throw BookingException::partySizeOutOfRange($tour->min_booking, $tour->max_booking);
        }

        $departsAt = Carbon::parse($departure?->start_date ?? $travelDate);

        if ($departsAt->lt(now()->addHours($tour->booking_cutoff_hours))) {
            throw BookingException::cutoffPassed($tour->booking_cutoff_hours);
        }

        $available = $this->seatsAvailable($tour, $departure, $travelDate);

        if ($available < $seats) {
            throw BookingException::seatsUnavailable($seats, $available);
        }
    }

    public function seatsAvailable(Tour $tour, ?TourDeparture $departure, ?string $travelDate = null): int
    {
        if ($departure) {
            return $departure->seats_available;
        }

        if ($tour->max_seats === 0) {
            return PHP_INT_MAX;   // open capacity (private / on-request tours)
        }

        $held = Booking::where('tour_id', $tour->id)
            ->whereDate('travel_date', $travelDate ?? today())
            ->whereIn('status', \App\Enums\BookingStatus::seatHolding())
            ->selectRaw('COALESCE(SUM(adults + children), 0) as seats')
            ->value('seats');

        return max(0, $tour->max_seats - (int) $held);
    }

    /** Locks the departure row so concurrent checkouts serialise on the same inventory. */
    public function lockDeparture(?int $departureId): ?TourDeparture
    {
        return $departureId ? TourDeparture::whereKey($departureId)->lockForUpdate()->first() : null;
    }

    public function holdSeats(?TourDeparture $departure, int $seats): void
    {
        if (! $departure) {
            return;
        }

        $departure->increment('seats_booked', $seats);

        if ($departure->fresh()->seats_available <= 0) {
            $departure->update(['status' => 'full']);
        }
    }

    public function releaseSeats(?TourDeparture $departure, int $seats): void
    {
        if (! $departure) {
            return;
        }

        $departure->decrement('seats_booked', min($seats, $departure->seats_booked));

        if ($departure->status === 'full' && $departure->fresh()->seats_available > 0) {
            $departure->update(['status' => 'open']);
        }
    }
}
