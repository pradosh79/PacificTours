<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentGateway: string
{
    case Stripe        = 'stripe';
    case PayPal        = 'paypal';
    case BankTransfer  = 'bank_transfer';
    case Cash          = 'cash';
    case Manual        = 'manual';

    public function isOnline(): bool
    {
        return in_array($this, [self::Stripe, self::PayPal], true);
    }

    public function label(): string
    {
        return match ($this) {
            self::Stripe       => 'Stripe',
            self::PayPal       => 'PayPal',
            self::BankTransfer => 'Bank Transfer',
            self::Cash         => 'Cash / Office',
            self::Manual       => 'Manual Entry',
        };
    }
}
