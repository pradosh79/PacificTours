<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function customers(array $filters = [], int $perPage = 20): LengthAwarePaginator;

    public function staff(array $filters = [], int $perPage = 20): LengthAwarePaginator;

    public function recentCustomers(int $limit = 5): Collection;

    public function topCustomers(int $limit = 5): Collection;
}
