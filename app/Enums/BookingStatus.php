<?php

declare(strict_types=1);

namespace App\Enums;

enum BookingStatus: string
{
    case Pending   = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    case Refunded  = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Cancelled => 'Cancelled',
            self::Completed => 'Completed',
            self::Refunded  => 'Refunded',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::Pending   => 'warning',
            self::Confirmed => 'primary',
            self::Cancelled => 'danger',
            self::Completed => 'success',
            self::Refunded  => 'secondary',
        };
    }

    /** Allowed state machine transitions. */
    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }

    /** @return array<int, self> */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::Pending   => [self::Confirmed, self::Cancelled],
            self::Confirmed => [self::Completed, self::Cancelled],
            self::Cancelled => [self::Refunded],
            self::Completed => [self::Refunded],
            self::Refunded  => [],
        };
    }

    /** Statuses that still hold inventory (seats). */
    public static function seatHolding(): array
    {
        return [self::Pending->value, self::Confirmed->value, self::Completed->value];
    }

    public static function options(): array
    {
        return array_column(array_map(fn (self $c) => ['value' => $c->value, 'label' => $c->label()], self::cases()), 'label', 'value');
    }
}
