<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Booking;
use App\Models\Page;
use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use App\Policies\BookingPolicy;
use App\Policies\PagePolicy;
use App\Policies\ReviewPolicy;
use App\Policies\TourPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Tour::class    => TourPolicy::class,
        Booking::class => BookingPolicy::class,
        Review::class  => ReviewPolicy::class,
        User::class    => UserPolicy::class,
        Page::class    => PagePolicy::class,
    ];

    public function boot(): void
    {
        Gate::before(fn (User $user) => $user->isSuperAdmin() ? true : null);

        Gate::define('access-admin', fn (User $user) => $user->isStaff());
        Gate::define('view-reports', fn (User $user) => $user->can('report.view'));
        Gate::define('manage-settings', fn (User $user) => $user->can('setting.update'));
    }
}
