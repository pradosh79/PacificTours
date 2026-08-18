<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Tour;
use App\Models\User;

class TourPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('tour.view');
    }

    public function view(User $user, Tour $tour): bool
    {
        return $user->can('tour.view');
    }

    public function create(User $user): bool
    {
        return $user->can('tour.create');
    }

    public function update(User $user, Tour $tour): bool
    {
        // Tour operators only edit the tours they authored.
        if ($user->hasRole(\App\Enums\RoleName::TourOperator->value)) {
            return $tour->created_by === $user->id;
        }

        return $user->can('tour.update');
    }

    public function publish(User $user, Tour $tour): bool
    {
        return $user->can('tour.publish');
    }

    public function delete(User $user, Tour $tour): bool
    {
        return $user->can('tour.delete') && $tour->bookings()->doesntExist();
    }
}
