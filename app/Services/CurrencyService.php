<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;

/**
 * Display-currency conversion.
 *
 * Deliberate rule: money is *stored* and *charged* in the base currency
 * (bookings.currency). Conversion is a presentation concern only — a customer
 * browsing in EUR still has their card charged in CAD, and the booking row
 * records CAD. Converting at write time would mean historical bookings silently
 * re-valuing whenever a rate moved, which is exactly what an accountant does
 * not want.
 */
class CurrencyService
{
    private const CACHE_KEY = 'currencies:active';

    public function base(): Currency
    {
        return $this->all()->firstWhere('is_default', true)
            ?? $this->all()->first()
            ?? new Currency(['code' => config('travel.currency.default'), 'symbol' => '$', 'exchange_rate' => 1]);
    }

    /** @return \Illuminate\Support\Collection<int, Currency> */
    public function all()
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => Currency::where('is_active', true)->get());
    }

    public function find(?string $code): ?Currency
    {
        return $code ? $this->all()->firstWhere('code', strtoupper($code)) : null;
    }

    /** The currency the visitor is browsing in — session, then user, then base. */
    public function display(): Currency
    {
        return $this->find(session('currency'))
            ?? $this->find(auth()->user()?->currency)
            ?? $this->base();
    }

    public function convert(float $amount, ?Currency $to = null, ?Currency $from = null): float
    {
        $to   ??= $this->display();
        $from ??= $this->base();

        if ($to->code === $from->code) {
            return round($amount, 2);
        }

        // Rates are expressed relative to the base currency.
        $inBase = (float) $from->exchange_rate > 0 ? $amount / (float) $from->exchange_rate : $amount;

        return round($inBase * (float) $to->exchange_rate, 2);
    }

    public function format(float $amount, ?Currency $currency = null, bool $convert = true): string
    {
        $currency = $currency ?? $this->display();
        $value    = $convert ? $this->convert($amount, $currency) : $amount;

        return $currency->symbol.number_format($value, 2);
    }

    /**
     * A converted price shown next to the charged price. Returns null when the
     * two match, so templates can simply skip the hint.
     */
    public function approximateHint(float $amount): ?string
    {
        $display = $this->display();

        if ($display->code === $this->base()->code) {
            return null;
        }

        return '≈ '.$this->format($amount, $display).' '.$display->code;
    }

    public function switchTo(string $code): bool
    {
        if (! $currency = $this->find($code)) {
            return false;
        }

        session(['currency' => $currency->code]);

        return true;
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
