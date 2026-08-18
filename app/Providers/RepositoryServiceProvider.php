<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\CouponRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\TourRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

/**
 * One place to swap a data source. Add a caching decorator here and no calling
 * code changes.
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array<class-string, class-string> */
    public array $bindings = [
        TourRepositoryInterface::class    => TourRepository::class,
        BookingRepositoryInterface::class => BookingRepository::class,
        PaymentRepositoryInterface::class => PaymentRepository::class,
        UserRepositoryInterface::class    => UserRepository::class,
        CouponRepositoryInterface::class  => CouponRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->bindings as $contract => $implementation) {
            $this->app->bind($contract, $implementation);
        }
    }
}
