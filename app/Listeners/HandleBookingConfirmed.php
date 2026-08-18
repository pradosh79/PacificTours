<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookingConfirmed;
use App\Jobs\GenerateInvoicePdf;
use App\Notifications\BookingConfirmedNotification;
use App\Services\DashboardService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class HandleBookingConfirmed implements ShouldQueue
{
    public string $queue = 'notifications';

    public function __construct(private readonly DashboardService $dashboard) {}

    public function handle(BookingConfirmed $event): void
    {
        $booking = $event->booking;

        if ($booking->invoice) {
            GenerateInvoicePdf::dispatch($booking->invoice->id);
        }

        $booking->user
            ? $booking->user->notify(new BookingConfirmedNotification($booking))
            : Notification::route('mail', $booking->customer_email)->notify(new BookingConfirmedNotification($booking));

        $this->dashboard->flush();
    }
}
