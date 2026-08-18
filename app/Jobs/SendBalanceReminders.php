<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Notifications\BalanceDueReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

/**
 * Scheduled daily. Chases the outstanding balance at 30 / 14 / 7 days out.
 */
class SendBalanceReminders implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    public function handle(): void
    {
        foreach ([30, 14, 7] as $days) {
            Booking::query()
                ->where('status', BookingStatus::Confirmed->value)
                ->where('due_amount', '>', 0)
                ->whereDate('travel_date', today()->addDays($days))
                ->with(['user', 'tour:id,title'])
                ->chunkById(200, function ($bookings) use ($days): void {
                    foreach ($bookings as $booking) {
                        $booking->user
                            ? $booking->user->notify(new BalanceDueReminder($booking, $days))
                            : Notification::route('mail', $booking->customer_email)
                                ->notify(new BalanceDueReminder($booking, $days));
                    }
                });
        }
    }
}
