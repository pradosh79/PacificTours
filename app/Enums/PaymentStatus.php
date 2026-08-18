<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatus: string
{
    case Unpaid           = 'unpaid';
    case PartiallyPaid    = 'partially_paid';
    case DepositPaid      = 'deposit_paid';
    case Paid             = 'paid';
    case Failed           = 'failed';
    case Refunded         = 'refunded';
    case PartiallyRefunded = 'partially_refunded';

    public function badge(): string
    {
        return match ($this) {
            self::Paid                                   => 'success',
            self::DepositPaid, self::PartiallyPaid       => 'info',
            self::Unpaid                                 => 'warning',
            self::Failed                                 => 'danger',
            self::Refunded, self::PartiallyRefunded      => 'secondary',
        };
    }

    public function label(): string
    {
        return ucwords(str_replace('_', ' ', $this->value));
    }
}
