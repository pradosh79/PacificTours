<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /** Super admin bypasses every check. */
    public function before(User $user, string $ability): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('booking.view');
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->can('booking.view') || $booking->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('booking.create') || $user->isCustomer();
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->can('booking.update')
            && $booking->status !== BookingStatus::Completed;
    }

    public function confirm(User $user, Booking $booking): bool
    {
        return $user->can('booking.confirm')
            && $booking->status->canTransitionTo(BookingStatus::Confirmed);
    }

    /** Customers may cancel their own booking while it is still cancellable. */
    public function cancel(User $user, Booking $booking): bool
    {
        if ($booking->user_id === $user->id && $booking->isCancellable()) {
            return true;
        }

        return $user->can('booking.cancel') && $booking->isCancellable();
    }

    public function refund(User $user, Booking $booking): bool
    {
        return $user->can('payment.refund');
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->can('booking.delete');
    }
}
