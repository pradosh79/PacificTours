<?php

declare(strict_types=1);

namespace App\Enums;

enum TourStatus: string
{
    case Draft     = 'draft';
    case Published = 'published';
    case Paused    = 'paused';
    case Archived  = 'archived';

    public function isBookable(): bool
    {
        return $this === self::Published;
    }

    public function badge(): string
    {
        return match ($this) {
            self::Published => 'success',
            self::Draft     => 'secondary',
            self::Paused    => 'warning',
            self::Archived  => 'dark',
        };
    }
}
