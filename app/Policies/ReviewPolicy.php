<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('review.view');
    }

    public function approve(User $user, Review $review): bool
    {
        return $user->can('review.approve');
    }

    public function update(User $user, Review $review): bool
    {
        return $user->can('review.update') || $review->user_id === $user->id;
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->can('review.delete');
    }

    /** A customer may review a tour once, after a completed booking. */
    public function createFor(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id
            && $booking->status === \App\Enums\BookingStatus::Completed
            && $booking->review()->doesntExist();
    }
}
