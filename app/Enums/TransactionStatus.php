<?php

declare(strict_types=1);

namespace App\Enums;

enum TransactionStatus: string
{
    case Initiated = 'initiated';
    case Pending   = 'pending';
    case Succeeded = 'succeeded';
    case Failed    = 'failed';
    case Cancelled = 'cancelled';
    case Refunded  = 'refunded';

    public function badge(): string
    {
        return match ($this) {
            self::Succeeded             => 'success',
            self::Refunded              => 'info',
            self::Failed, self::Cancelled => 'danger',
            self::Pending, self::Initiated => 'warning',
        };
    }
}
