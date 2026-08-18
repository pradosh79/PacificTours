<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class PaymentException extends Exception
{
    public static function gatewayNotConfigured(string $gateway): self
    {
        return new self("The {$gateway} gateway is not configured.");
    }

    public static function declined(string $reason): self
    {
        return new self("Payment declined: {$reason}");
    }

    public static function amountMismatch(): self
    {
        return new self('The amount received does not match the amount due for this booking.');
    }

    public static function refundExceedsCapture(): self
    {
        return new self('Refund amount is greater than the remaining captured amount.');
    }
}
