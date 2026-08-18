<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('user.view');
    }

    public function create(User $user): bool
    {
        return $user->can('user.create');
    }

    public function update(User $user, User $target): bool
    {
        if ($user->id === $target->id) {
            return true;
        }

        // Nobody but a super admin may edit a super admin.
        return $user->can('user.update') && ! $target->isSuperAdmin();
    }

    public function delete(User $user, User $target): bool
    {
        return $user->can('user.delete') && $user->id !== $target->id && ! $target->isSuperAdmin();
    }

    public function impersonate(User $user, User $target): bool
    {
        return false;   // reserved for super admin via before()
    }
}
