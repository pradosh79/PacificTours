<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Uniform return shape for every gateway so the checkout controller never
 * branches on the gateway name.
 */
final class PaymentResult extends BaseData
{
    public function __construct(
        public readonly bool $success,
        public readonly string $gateway,
        public readonly ?string $transactionId = null,
        public readonly ?string $reference = null,
        public readonly ?string $redirectUrl = null,
        public readonly ?string $clientSecret = null,
        public readonly float $amount = 0.0,
        public readonly string $currency = 'CAD',
        public readonly ?string $message = null,
        public readonly array $raw = [],
    ) {}

    public function requiresRedirect(): bool
    {
        return filled($this->redirectUrl);
    }
}
