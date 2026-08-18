<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\DTOs\PaymentResult;
use App\Enums\PaymentGateway as GatewayEnum;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Str;

/**
 * Office / phone bookings: sales staff records a cash, cheque or e-transfer
 * payment. Same contract, so the ledger stays uniform.
 */
class ManualGateway implements PaymentGatewayContract
{
    public function key(): string
    {
        return GatewayEnum::Manual->value;
    }

    public function charge(Booking $booking, float $amount, array $options = []): PaymentResult
    {
        return new PaymentResult(
            success: true,
            gateway: $this->key(),
            transactionId: 'MAN-'.Str::upper(Str::random(12)),
            amount: $amount,
            currency: $booking->currency,
            message: $options['note'] ?? 'Recorded manually',
        );
    }

    public function verify(array $payload): PaymentResult
    {
        return new PaymentResult(success: true, gateway: $this->key(), transactionId: $payload['transaction_id'] ?? null);
    }

    public function refund(Payment $payment, float $amount, ?string $reason = null): PaymentResult
    {
        return new PaymentResult(
            success: true,
            gateway: $this->key(),
            transactionId: 'MANREF-'.Str::upper(Str::random(10)),
            amount: $amount,
            currency: $payment->currency,
            message: $reason,
        );
    }

    public function parseWebhook(string $rawPayload, array $headers): array
    {
        return ['id' => null, 'type' => 'manual', 'payload' => []];
    }
}
