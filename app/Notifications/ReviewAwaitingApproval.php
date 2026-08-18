<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ReviewAwaitingApproval extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Review $review) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'review.pending',
            'title'   => 'Review awaiting approval',
            'message' => "{$this->review->reviewer_name} rated {$this->review->tour->title} {$this->review->rating}/5.",
            'url'     => route('admin.reviews.index', ['status' => 'pending']),
        ];
    }
}
