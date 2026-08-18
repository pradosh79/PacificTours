<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Payment $payment) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment received · '.money($this->payment->amount))
            ->markdown('emails.payments.received', ['payment' => $this->payment]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'payment.received',
            'title'   => 'Payment received',
            'message' => money($this->payment->amount).' via '.$this->payment->gateway->label(),
            'url'     => route('admin.payments.show', $this->payment->uuid),
        ];
    }
}
