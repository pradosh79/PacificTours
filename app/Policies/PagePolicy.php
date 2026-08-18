<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('cms.view');
    }

    public function update(User $user, Page $page): bool
    {
        return $user->can('cms.update');
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->can('cms.delete') && ! $page->is_system;
    }
}
