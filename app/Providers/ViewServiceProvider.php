<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\TourCategory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Composers keep controllers free of layout concerns, so replacing the
        // Blade theme later does not touch any controller.
        View::composer('web.partials.search-bar', function ($view): void {
            $view->with('categories', Cache::remember('nav:categories', now()->addHour(),
                fn () => TourCategory::active()->root()->orderBy('sort_order')->get(['id', 'name', 'slug'])));
        });

        Blade::directive('money', fn ($expr) => "<?php echo money($expr); ?>");
        Blade::if('role', fn (string $role) => auth()->check() && auth()->user()->hasRole($role));
    }
}
