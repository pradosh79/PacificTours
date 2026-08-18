<?php

declare(strict_types=1);

namespace App\Enums;

enum UserStatus: string
{
    case Active    = 'active';
    case Inactive  = 'inactive';
    case Suspended = 'suspended';
    case Banned    = 'banned';

    public function canLogin(): bool
    {
        return $this === self::Active;
    }
}
