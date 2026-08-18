<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingReceived extends Notification implements ShouldQueue
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
            ->subject("We've got your booking · {$this->booking->booking_number}")
            ->markdown('emails.bookings.received', ['booking' => $this->booking]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'booking.received',
            'title'   => 'Booking received',
            'message' => "Booking {$this->booking->booking_number} for {$this->booking->tour->title} is awaiting payment.",
            'url'     => route('customer.bookings.show', $this->booking->uuid),
        ];
    }
}
