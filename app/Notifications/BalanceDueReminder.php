<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BalanceDueReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Booking $booking,
        public readonly int $daysUntilTravel,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Balance due for {$this->booking->tour->title}")
            ->line("Your trip leaves in {$this->daysUntilTravel} days.")
            ->line('Outstanding balance: '.money($this->booking->due_amount))
            ->action('Pay balance', route('customer.bookings.pay', $this->booking->uuid));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'booking.balance_due',
            'title'   => 'Balance due',
            'message' => money($this->booking->due_amount).' outstanding on '.$this->booking->booking_number,
            'url'     => route('customer.bookings.show', $this->booking->uuid),
        ];
    }
}
