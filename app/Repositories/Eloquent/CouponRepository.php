<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function __construct(Coupon $model)
    {
        parent::__construct($model);
    }

    public function findUsableByCode(string $code): ?Coupon
    {
        return $this->query()->usable()->whereRaw('UPPER(code) = ?', [strtoupper($code)])->first();
    }

    public function usageCountForUser(Coupon $coupon, ?int $userId, ?string $email = null): int
    {
        return $coupon->usages()
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->when(! $userId && $email, fn ($q) => $q->whereHas('booking', fn ($s) => $s->where('customer_email', $email)))
            ->count();
    }
}
