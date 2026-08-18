<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

/**
 * Returns held seats to inventory when a pending booking is never paid.
 * Window is configurable in Settings → General (default 48h).
 */
class ExpireUnpaidBookings implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('maintenance');
    }

    public function handle(BookingService $bookings): void
    {
        $hours = (int) setting('general.unpaid_booking_ttl_hours', 48);

        Booking::query()
            ->where('status', BookingStatus::Pending->value)
            ->where('paid_amount', 0)
            ->where('created_at', '<=', now()->subHours($hours))
            ->chunkById(100, function ($rows) use ($bookings): void {
                foreach ($rows as $booking) {
                    $bookings->cancel($booking, "Auto-cancelled: unpaid after {$booking->created_at->diffForHumans()}");
                }
            });
    }
}
