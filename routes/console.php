<?php

declare(strict_types=1);

use App\Jobs\CompletePastTours;
use App\Jobs\ExpireUnpaidBookings;
use App\Jobs\RebuildSitemap;
use App\Jobs\SendBalanceReminders;
use App\Jobs\SendTripReminders;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Scheduled work
|--------------------------------------------------------------------------
| A single cron entry drives all of it:
|   * * * * * cd /var/www/pacific-tours && php artisan schedule:run >> /dev/null 2>&1
*/

Schedule::job(new ExpireUnpaidBookings)->hourly()->withoutOverlapping();
Schedule::job(new CompletePastTours)->dailyAt('01:00');
Schedule::job(new SendBalanceReminders)->dailyAt('09:00');
Schedule::job(new SendTripReminders(3))->dailyAt('09:15');
Schedule::job(new RebuildSitemap)->dailyAt('02:00');

Schedule::command('queue:prune-batches --hours=48')->daily();
Schedule::command('model:prune')->daily();
Schedule::command('backup:run --only-db')->dailyAt('03:00')->onOneServer();
Schedule::command('telescope:prune --hours=48')->daily();
