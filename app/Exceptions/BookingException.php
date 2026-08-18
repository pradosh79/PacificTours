<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class BookingException extends Exception
{
    public static function seatsUnavailable(int $requested, int $available): self
    {
        return new self("Only {$available} seat(s) left on this departure, {$requested} requested.");
    }

    public static function tourNotBookable(): self
    {
        return new self('This tour is not currently open for booking.');
    }

    public static function cutoffPassed(int $hours): self
    {
        return new self("Bookings close {$hours} hours before departure.");
    }

    public static function invalidTransition(string $from, string $to): self
    {
        return new self("A booking cannot move from {$from} to {$to}.");
    }

    public static function partySizeOutOfRange(int $min, int $max): self
    {
        return new self("This tour accepts between {$min} and {$max} travellers per booking.");
    }
}
