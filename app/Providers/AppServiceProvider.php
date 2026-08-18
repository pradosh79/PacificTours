<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use App\Observers\BookingObserver;
use App\Observers\ReviewObserver;
use App\Observers\TourObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());
        Model::unguard(false);

        Paginator::useBootstrapFive();

        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        Tour::observe(TourObserver::class);
        Booking::observe(BookingObserver::class);
        Review::observe(ReviewObserver::class);
        User::observe(UserObserver::class);
    }
}
