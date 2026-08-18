<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Human-readable sequential references (PT-2026-000123) generated inside the
 * caller's transaction with a row lock, so two concurrent checkouts cannot
 * receive the same number.
 */
final class NumberGenerator
{
    public static function booking(): string
    {
        return self::next('bookings', 'booking_number', config('travel.prefixes.booking', 'PT'));
    }

    public static function invoice(): string
    {
        return self::next('invoices', 'invoice_number', config('travel.prefixes.invoice', 'INV'));
    }

    public static function ticket(): string
    {
        return self::next('tickets', 'ticket_number', config('travel.prefixes.ticket', 'TKT'));
    }

    public static function tourCode(): string
    {
        return self::next('tours', 'code', config('travel.prefixes.tour', 'PT-T'), false);
    }

    private static function next(string $table, string $column, string $prefix, bool $withYear = true): string
    {
        $year    = now()->year;
        $pattern = $withYear ? "{$prefix}-{$year}-" : "{$prefix}-";

        $last = DB::table($table)
            ->where($column, 'like', $pattern.'%')
            ->lockForUpdate()
            ->orderByDesc($column)
            ->value($column);

        $sequence = $last ? ((int) substr((string) $last, strlen($pattern))) + 1 : 1;

        return $pattern.str_pad((string) $sequence, 6, '0', STR_PAD_LEFT);
    }
}
