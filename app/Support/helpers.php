<?php

declare(strict_types=1);

use App\Services\SettingService;

if (! function_exists('setting')) {
    /** Reads a cached site setting: setting('general.company_name', 'Pacific Tours'). */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingService::class)->get($key, $default);
    }
}

if (! function_exists('money')) {
    function money(float|int|string|null $amount, ?string $currency = null): string
    {
        $currency ??= config('travel.currency.default');
        $symbol = config('travel.currency.symbols.'.$currency, '$');

        return $symbol.number_format((float) $amount, 2);
    }
}

if (! function_exists('upload_url')) {
    function upload_url(?string $path, string $fallback = 'images/placeholder.jpg'): string
    {
        return $path ? asset('storage/'.$path) : asset($fallback);
    }
}

if (! function_exists('money_in')) {
    /**
     * Format an amount in the visitor's chosen display currency.
     * Use money() for anything that will actually be charged; use money_in()
     * only for browsing hints, so the two never get confused.
     */
    function money_in(float|int|string|null $amount, ?string $code = null): string
    {
        $service = app(App\Services\CurrencyService::class);

        return $service->format((float) $amount, $service->find($code));
    }
}

if (! function_exists('money_hint')) {
    /** "≈ €612.40 EUR", or null when the visitor is already browsing in the base currency. */
    function money_hint(float|int|string|null $amount): ?string
    {
        return app(App\Services\CurrencyService::class)->approximateHint((float) $amount);
    }
}
