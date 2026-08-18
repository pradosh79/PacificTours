<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\DTOs\PaymentResult;
use App\Enums\PaymentGateway as GatewayEnum;
use App\Exceptions\PaymentException;
use App\Models\Booking;
use App\Models\Payment;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeGateway implements PaymentGatewayContract
{
    private StripeClient $client;

    public function __construct()
    {
        $secret = setting('payment.stripe_secret') ?: config('services.stripe.secret');

        if (blank($secret)) {
            throw PaymentException::gatewayNotConfigured('Stripe');
        }

        $this->client = new StripeClient($secret);
    }

    public function key(): string
    {
        return GatewayEnum::Stripe->value;
    }

    public function charge(Booking $booking, float $amount, array $options = []): PaymentResult
    {
        $session = $this->client->checkout->sessions->create([
            'mode'                 => 'payment',
            'customer_email'       => $booking->customer_email,
            'client_reference_id'  => $booking->uuid,
            'line_items'           => [[
                'quantity'   => 1,
                'price_data' => [
                    'currency'     => strtolower($booking->currency),
                    'unit_amount'  => (int) round($amount * 100),
                    'product_data' => [
                        'name'        => $booking->tour->title,
                        'description' => "Booking {$booking->booking_number} · {$booking->travel_date->toFormattedDateString()}",
                    ],
                ],
            ]],
            'metadata' => [
                'booking_uuid'   => $booking->uuid,
                'booking_number' => $booking->booking_number,
                'payment_type'   => $options['type'] ?? 'full',
            ],
            'success_url' => route('checkout.success', ['booking' => $booking->uuid]).'&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('checkout.cancel', ['booking' => $booking->uuid]),
        ], ['idempotency_key' => 'bk_'.$booking->uuid.'_'.(int) round($amount * 100)]);

        return new PaymentResult(
            success: true,
            gateway: $this->key(),
            transactionId: $session->payment_intent,
            reference: $session->id,
            redirectUrl: $session->url,
            amount: $amount,
            currency: $booking->currency,
            raw: $session->toArray(),
        );
    }

    public function verify(array $payload): PaymentResult
    {
        $session = $this->client->checkout->sessions->retrieve($payload['session_id'], ['expand' => ['payment_intent']]);
        $paid    = $session->payment_status === 'paid';

        return new PaymentResult(
            success: $paid,
            gateway: $this->key(),
            transactionId: is_string($session->payment_intent) ? $session->payment_intent : $session->payment_intent->id,
            reference: $session->id,
            amount: $session->amount_total / 100,
            currency: strtoupper($session->currency),
            message: $paid ? 'Payment captured' : 'Payment not completed',
            raw: $session->toArray(),
        );
    }

    public function refund(Payment $payment, float $amount, ?string $reason = null): PaymentResult
    {
        $refund = $this->client->refunds->create([
            'payment_intent' => $payment->transaction_id,
            'amount'         => (int) round($amount * 100),
            'metadata'       => ['reason' => $reason ?? 'requested_by_customer'],
        ]);

        return new PaymentResult(
            success: in_array($refund->status, ['succeeded', 'pending'], true),
            gateway: $this->key(),
            transactionId: $refund->id,
            amount: $amount,
            currency: $payment->currency,
            message: $refund->status,
            raw: $refund->toArray(),
        );
    }

    public function parseWebhook(string $rawPayload, array $headers): array
    {
        $secret = setting('payment.stripe_webhook_secret') ?: config('services.stripe.webhook_secret');
        $event  = Webhook::constructEvent($rawPayload, $headers['stripe-signature'][0] ?? '', $secret);

        return [
            'id'      => $event->id,
            'type'    => $event->type,
            'payload' => $event->toArray(),
        ];
    }
}
