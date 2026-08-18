<?php

declare(strict_types=1);

namespace App\Enums;

enum DiscountType: string
{
    case None       = 'none';
    case Percentage = 'percentage';
    case Fixed      = 'fixed';

    public function apply(float $amount, float $value): float
    {
        return match ($this) {
            self::None       => 0.0,
            self::Percentage => round($amount * ($value / 100), 2),
            self::Fixed      => min($value, $amount),
        };
    }
}
