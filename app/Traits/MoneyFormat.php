<?php

declare(strict_types=1);

namespace App\Traits;

trait MoneyFormat
{
    public function money(float|int|string|null $amount, ?string $currency = null): string
    {
        $currency ??= $this->currency ?? config('travel.currency.default');
        $symbol = config('travel.currency.symbols.'.$currency, '$');

        return $symbol.number_format((float) $amount, 2);
    }
}
