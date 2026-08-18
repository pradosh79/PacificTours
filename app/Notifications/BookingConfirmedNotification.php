<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Booking $booking) {}

    public function via(object $notifiable): array
    {
        return $this->booking->user_id ? ['mail', 'database'] : ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("You're going · {$this->booking->tour->title}")
            ->markdown('emails.bookings.confirmed', ['booking' => $this->booking]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'booking.confirmed',
            'title'   => 'Booking confirmed',
            'message' => "{$this->booking->booking_number} is confirmed for ".$this->booking->travel_date->toFormattedDateString().'.',
            'url'     => route('customer.bookings.show', $this->booking->uuid),
        ];
    }
}
