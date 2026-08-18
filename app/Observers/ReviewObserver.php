<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Review;
use App\Repositories\Contracts\TourRepositoryInterface;

class ReviewObserver
{
    public function __construct(private readonly TourRepositoryInterface $tours) {}

    public function saved(Review $review): void
    {
        if ($review->wasChanged('status') || $review->wasRecentlyCreated) {
            $this->tours->recalculateRating($review->tour);
        }
    }

    public function deleted(Review $review): void
    {
        $this->tours->recalculateRating($review->tour);
    }
}
