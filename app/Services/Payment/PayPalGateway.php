<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\DTOs\PaymentResult;
use App\Enums\PaymentGateway as GatewayEnum;
use App\Exceptions\PaymentException;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

/**
 * PayPal Orders v2. Optional module: enable it from Settings → Payment without
 * touching code, because the gateway is resolved by key at runtime.
 */
class PayPalGateway implements PaymentGatewayContract
{
    public function key(): string
    {
        return GatewayEnum::PayPal->value;
    }

    public function charge(Booking $booking, float $amount, array $options = []): PaymentResult
    {
        $response = $this->api()->post('/v2/checkout/orders', [
            'intent'         => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => $booking->uuid,
                'custom_id'    => $booking->booking_number,
                'amount'       => [
                    'currency_code' => $booking->currency,
                    'value'         => number_format($amount, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'brand_name' => setting('general.company_name', 'Pacific Tours Canada'),
                'return_url' => route('checkout.success', ['booking' => $booking->uuid]),
                'cancel_url' => route('checkout.cancel', ['booking' => $booking->uuid]),
            ],
        ])->throw()->json();

        $approve = collect($response['links'] ?? [])->firstWhere('rel', 'approve')['href'] ?? null;

        return new PaymentResult(
            success: true,
            gateway: $this->key(),
            transactionId: $response['id'],
            reference: $response['id'],
            redirectUrl: $approve,
            amount: $amount,
            currency: $booking->currency,
            raw: $response,
        );
    }

    public function verify(array $payload): PaymentResult
    {
        $orderId  = $payload['token'] ?? $payload['order_id'];
        $response = $this->api()->post("/v2/checkout/orders/{$orderId}/capture")->throw()->json();

        $capture = data_get($response, 'purchase_units.0.payments.captures.0', []);

        return new PaymentResult(
            success: ($response['status'] ?? '') === 'COMPLETED',
            gateway: $this->key(),
            transactionId: $capture['id'] ?? $orderId,
            reference: $orderId,
            amount: (float) data_get($capture, 'amount.value', 0),
            currency: data_get($capture, 'amount.currency_code', 'CAD'),
            raw: $response,
        );
    }

    public function refund(Payment $payment, float $amount, ?string $reason = null): PaymentResult
    {
        $response = $this->api()->post("/v2/payments/captures/{$payment->transaction_id}/refund", [
            'amount'    => ['currency_code' => $payment->currency, 'value' => number_format($amount, 2, '.', '')],
            'note_to_payer' => $reason,
        ])->throw()->json();

        return new PaymentResult(
            success: ($response['status'] ?? '') === 'COMPLETED',
            gateway: $this->key(),
            transactionId: $response['id'] ?? null,
            amount: $amount,
            currency: $payment->currency,
            raw: $response,
        );
    }

    public function parseWebhook(string $rawPayload, array $headers): array
    {
        $event = json_decode($rawPayload, true, 512, JSON_THROW_ON_ERROR);

        return [
            'id'      => $event['id'] ?? null,
            'type'    => $event['event_type'] ?? 'unknown',
            'payload' => $event,
        ];
    }

    private function api()
    {
        $id     = setting('payment.paypal_client_id') ?: config('services.paypal.client_id');
        $secret = setting('payment.paypal_secret') ?: config('services.paypal.secret');

        if (blank($id) || blank($secret)) {
            throw PaymentException::gatewayNotConfigured('PayPal');
        }

        $base  = config('services.paypal.mode') === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';

        $token = cache()->remember('paypal:token', now()->addMinutes(25), fn () => Http::asForm()
            ->withBasicAuth($id, $secret)
            ->post($base.'/v1/oauth2/token', ['grant_type' => 'client_credentials'])
            ->throw()->json('access_token'));

        return Http::withToken($token)->acceptJson()->baseUrl($base);
    }
}
