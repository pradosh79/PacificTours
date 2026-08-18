<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentType: string
{
    case Full    = 'full';
    case Deposit = 'deposit';
    case Balance = 'balance';
    case Partial = 'partial';
    case Refund  = 'refund';
}
