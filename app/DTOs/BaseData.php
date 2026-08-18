<?php

declare(strict_types=1);

namespace App\DTOs;

abstract class BaseData
{
    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
