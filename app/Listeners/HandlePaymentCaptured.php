<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\RoleName;
use App\Events\PaymentCaptured;
use App\Models\User;
use App\Notifications\PaymentReceived;
use App\Services\BookingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class HandlePaymentCaptured implements ShouldQueue
{
    public string $queue = 'notifications';

    public function __construct(private readonly BookingService $bookings) {}

    public function handle(PaymentCaptured $event): void
    {
        $payment = $event->payment;
        $booking = $payment->booking;

        // Deposit or full payment both confirm the seat; the balance is chased later.
        if ($booking->status->canTransitionTo(\App\Enums\BookingStatus::Confirmed)) {
            $this->bookings->confirm($booking, 'Auto-confirmed after payment '.$payment->transaction_id);
        }

        $booking->user
            ? $booking->user->notify(new PaymentReceived($payment))
            : Notification::route('mail', $booking->customer_email)->notify(new PaymentReceived($payment));

        Notification::send(
            User::role([RoleName::SuperAdmin->value, RoleName::Admin->value])->get(),
            new PaymentReceived($payment)
        );
    }
}
