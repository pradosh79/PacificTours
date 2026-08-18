<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\Widget;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Header/footer chrome for the public site. Cached, so a Figma rebuild of the
 * layout keeps the same variable contract without new queries.
 */
class ShareCmsData
{
    public function handle(Request $request, Closure $next): Response
    {
        View::share('cms', Cache::remember('cms:chrome:'.app()->getLocale(), now()->addHour(), fn () => [
            'header_menu' => Menu::with('items.children')->where('location', 'header')->first(),
            'footer_menu' => Menu::with('items.children')->where('location', 'footer')->first(),
            'widgets'     => Widget::where('is_active', true)->orderBy('sort_order')->get()->groupBy('area'),
        ]));

        return $next($request);
    }
}
