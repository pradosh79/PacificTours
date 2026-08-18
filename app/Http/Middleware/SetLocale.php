<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $available = Cache::remember('languages:active', now()->addHour(),
            fn () => Language::active()->pluck('code')->toArray());

        $locale = $request->query('lang')
            ?? session('locale')
            ?? $request->user()?->locale
            ?? config('app.locale');

        if (in_array($locale, $available, true)) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}
