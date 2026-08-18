<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Notifications\TripReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class SendTripReminders implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly int $daysBefore = 3)
    {
        $this->onQueue('notifications');
    }

    public function handle(): void
    {
        Booking::query()
            ->where('status', BookingStatus::Confirmed->value)
            ->whereDate('travel_date', today()->addDays($this->daysBefore))
            ->with(['user', 'tour:id,title,pickup_location,meeting_point'])
            ->chunkById(200, function ($bookings): void {
                foreach ($bookings as $booking) {
                    $booking->user
                        ? $booking->user->notify(new TripReminder($booking))
                        : Notification::route('mail', $booking->customer_email)->notify(new TripReminder($booking));
                }
            });
    }
}
