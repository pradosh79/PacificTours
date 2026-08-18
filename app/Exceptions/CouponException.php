<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class CouponException extends Exception
{
    public static function invalid(): self
    {
        return new self('This promo code is not valid.');
    }

    public static function expired(): self
    {
        return new self('This promo code has expired.');
    }

    public static function limitReached(): self
    {
        return new self('This promo code has reached its usage limit.');
    }

    public static function minimumSpend(float $min): self
    {
        return new self('This promo code applies to bookings over '.money($min).'.');
    }

    public static function notApplicable(): self
    {
        return new self('This promo code does not apply to the selected tour.');
    }
}
