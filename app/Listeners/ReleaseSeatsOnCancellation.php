<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookingCancelled;
use App\Notifications\BookingCancelledNotification;
use App\Services\DashboardService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class ReleaseSeatsOnCancellation implements ShouldQueue
{
    public string $queue = 'notifications';

    public function __construct(private readonly DashboardService $dashboard) {}

    public function handle(BookingCancelled $event): void
    {
        // Seat release itself happens inside BookingService's transaction; this
        // listener only handles the after-effects.
        $booking = $event->booking;

        $booking->user
            ? $booking->user->notify(new BookingCancelledNotification($booking, $event->reason))
            : Notification::route('mail', $booking->customer_email)
                ->notify(new BookingCancelledNotification($booking, $event->reason));

        $this->dashboard->flush();
    }
}
