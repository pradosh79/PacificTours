<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CompletePastTours implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('maintenance');
    }

    public function handle(BookingService $bookings): void
    {
        Booking::query()
            ->where('status', BookingStatus::Confirmed->value)
            ->whereDate('return_date', '<', today())
            ->chunkById(200, function ($rows) use ($bookings): void {
                foreach ($rows as $booking) {
                    $bookings->complete($booking, 'Auto-completed after return date');
                }
            });
    }
}
