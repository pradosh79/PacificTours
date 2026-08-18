<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingForAdmin extends Notification implements ShouldQueue
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
            ->subject("New booking · {$this->booking->booking_number} · ".money($this->booking->grand_total))
            ->line("{$this->booking->customer_name} booked {$this->booking->tour->title}.")
            ->line('Travel date: '.$this->booking->travel_date->toFormattedDateString())
            ->line("Guests: {$this->booking->total_guests}")
            ->action('Open booking', route('admin.bookings.show', $this->booking->uuid));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'admin.booking.new',
            'title'   => 'New booking',
            'message' => "{$this->booking->customer_name} · ".money($this->booking->grand_total),
            'url'     => route('admin.bookings.show', $this->booking->uuid),
        ];
    }
}
