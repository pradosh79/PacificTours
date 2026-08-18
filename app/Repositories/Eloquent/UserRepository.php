<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\RoleName;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function customers(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery($filters)->role(RoleName::Customer->value)
            ->withCount('bookings')->latest('id')->paginate($perPage)->withQueryString();
    }

    public function staff(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery($filters)->role(RoleName::staff())
            ->with('roles:id,name')->latest('id')->paginate($perPage)->withQueryString();
    }

    public function recentCustomers(int $limit = 5): Collection
    {
        return $this->query()->customers()->latest('id')->limit($limit)->get();
    }

    public function topCustomers(int $limit = 5): Collection
    {
        return $this->query()->customers()
            ->withSum(['bookings' => fn ($q) => $q->revenueCounted()], 'grand_total')
            ->withCount('bookings')
            ->orderByDesc('bookings_sum_grand_total')
            ->limit($limit)->get();
    }

    private function baseQuery(array $filters)
    {
        return $this->query()
            ->when($filters['keyword'] ?? null, fn ($q, $v) => $q->where(fn ($s) => $s
                ->where('first_name', 'like', "%{$v}%")
                ->orWhere('last_name', 'like', "%{$v}%")
                ->orWhere('email', 'like', "%{$v}%")
                ->orWhere('phone', 'like', "%{$v}%")))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v));
    }
}
