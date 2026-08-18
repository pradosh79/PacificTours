<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\RoleName;
use App\Events\BookingCreated;
use App\Models\User;
use App\Notifications\BookingReceived;
use App\Notifications\NewBookingForAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendBookingNotifications implements ShouldQueue
{
    public string $queue = 'notifications';

    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;

        // Customer copy works for guest checkout too (route by email).
        $booking->user
            ? $booking->user->notify(new BookingReceived($booking))
            : Notification::route('mail', $booking->customer_email)->notify(new BookingReceived($booking));

        Notification::send(
            User::role([RoleName::SuperAdmin->value, RoleName::Admin->value, RoleName::Manager->value])->get(),
            new NewBookingForAdmin($booking)
        );
    }
}
