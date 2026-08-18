<?php

declare(strict_types=1);

namespace App\Enums;

enum DepositType: string
{
    case Disabled   = 'disabled';
    case Percentage = 'percentage';
    case Fixed      = 'fixed';
}
