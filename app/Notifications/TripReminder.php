<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TripReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Your trip departs soon · {$this->booking->tour->title}")
            ->markdown('emails.bookings.reminder', ['booking' => $this->booking]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'booking.reminder',
            'title'   => 'Trip reminder',
            'message' => 'Departure on '.$this->booking->travel_date->toFormattedDateString(),
            'url'     => route('customer.bookings.show', $this->booking->uuid),
        ];
    }
}
