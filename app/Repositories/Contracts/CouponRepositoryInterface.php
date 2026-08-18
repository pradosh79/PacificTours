<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Coupon;

interface CouponRepositoryInterface extends RepositoryInterface
{
    public function findUsableByCode(string $code): ?Coupon;

    public function usageCountForUser(Coupon $coupon, ?int $userId, ?string $email = null): int;
}
