<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\BookingCancelled;
use App\Events\BookingConfirmed;
use App\Events\BookingCreated;
use App\Events\PaymentCaptured;
use App\Events\ReviewSubmitted;
use App\Listeners\HandleBookingConfirmed;
use App\Listeners\HandlePaymentCaptured;
use App\Listeners\NotifyAdminOfReview;
use App\Listeners\ReleaseSeatsOnCancellation;
use App\Listeners\SendBookingNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BookingCreated::class   => [SendBookingNotifications::class],
        BookingConfirmed::class => [HandleBookingConfirmed::class],
        BookingCancelled::class => [ReleaseSeatsOnCancellation::class],
        PaymentCaptured::class  => [HandlePaymentCaptured::class],
        ReviewSubmitted::class  => [NotifyAdminOfReview::class],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
