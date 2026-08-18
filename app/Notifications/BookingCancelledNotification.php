<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Booking $booking,
        public readonly ?string $reason = null,
    ) {}

    public function via(object $notifiable): array
    {
        return $this->booking->user_id ? ['mail', 'database'] : ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Booking cancelled · {$this->booking->booking_number}")
            ->markdown('emails.bookings.cancelled', ['booking' => $this->booking, 'reason' => $this->reason]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'booking.cancelled',
            'title'   => 'Booking cancelled',
            'message' => "{$this->booking->booking_number} has been cancelled.",
            'url'     => route('customer.bookings.show', $this->booking->uuid),
        ];
    }
}
