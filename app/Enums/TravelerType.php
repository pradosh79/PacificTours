<?php

declare(strict_types=1);

namespace App\Enums;

enum TravelerType: string
{
    case Adult  = 'adult';
    case Child  = 'child';
    case Infant = 'infant';
}
