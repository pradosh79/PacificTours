<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\DTOs\PaymentResult;
use App\Models\Booking;
use App\Models\Payment;

/**
 * Every gateway implements this. Adding Square or Moneris later means one new
 * class plus one config entry — no controller or service changes.
 */
interface PaymentGatewayContract
{
    public function key(): string;

    /** Starts a charge: returns a redirect URL, a client secret, or an immediate success. */
    public function charge(Booking $booking, float $amount, array $options = []): PaymentResult;

    /** Confirms the charge after the customer returns from the gateway. */
    public function verify(array $payload): PaymentResult;

    public function refund(Payment $payment, float $amount, ?string $reason = null): PaymentResult;

    /** Verifies the webhook signature and returns the normalised event. */
    public function parseWebhook(string $rawPayload, array $headers): array;
}
