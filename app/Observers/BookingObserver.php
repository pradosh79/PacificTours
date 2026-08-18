<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Booking;
use App\Services\DashboardService;

class BookingObserver
{
    public function __construct(private readonly DashboardService $dashboard) {}

    public function created(Booking $booking): void
    {
        $this->dashboard->flush();
    }

    public function updated(Booking $booking): void
    {
        if ($booking->wasChanged(['status', 'payment_status', 'grand_total'])) {
            $this->dashboard->flush();
        }
    }
}
