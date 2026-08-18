<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleName: string
{
    case SuperAdmin     = 'super-admin';
    case Admin          = 'admin';
    case Manager        = 'manager';
    case SalesExecutive = 'sales-executive';
    case TourOperator   = 'tour-operator';
    case Customer       = 'customer';

    public function label(): string
    {
        return ucwords(str_replace('-', ' ', $this->value));
    }

    /** Roles allowed into /admin. */
    public static function staff(): array
    {
        return [
            self::SuperAdmin->value,
            self::Admin->value,
            self::Manager->value,
            self::SalesExecutive->value,
            self::TourOperator->value,
        ];
    }
}
