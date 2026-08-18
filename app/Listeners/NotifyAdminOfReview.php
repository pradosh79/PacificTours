<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\RoleName;
use App\Events\ReviewSubmitted;
use App\Models\User;
use App\Notifications\ReviewAwaitingApproval;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAdminOfReview implements ShouldQueue
{
    public string $queue = 'notifications';

    public function handle(ReviewSubmitted $event): void
    {
        Notification::send(
            User::role([RoleName::SuperAdmin->value, RoleName::Admin->value, RoleName::Manager->value])->get(),
            new ReviewAwaitingApproval($event->review)
        );
    }
}
