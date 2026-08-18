<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\CouponException;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Tour;
use App\Repositories\Contracts\CouponRepositoryInterface;

class CouponService
{
    public function __construct(private readonly CouponRepositoryInterface $coupons) {}

    /**
     * Validates a code against the cart context and returns the coupon.
     *
     * @throws CouponException
     */
    public function validate(string $code, Tour $tour, float $subtotal, ?int $userId = null, ?string $email = null): Coupon
    {
        $coupon = $this->coupons->findUsableByCode($code) ?? throw CouponException::invalid();

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            throw CouponException::expired();
        }

        if ($coupon->hasReachedGlobalLimit()) {
            throw CouponException::limitReached();
        }

        if ($coupon->min_spend && $subtotal < (float) $coupon->min_spend) {
            throw CouponException::minimumSpend((float) $coupon->min_spend);
        }

        if (! $this->appliesToTour($coupon, $tour)) {
            throw CouponException::notApplicable();
        }

        if ($this->coupons->usageCountForUser($coupon, $userId, $email) >= $coupon->usage_limit_per_user) {
            throw CouponException::limitReached();
        }

        return $coupon;
    }

    public function discountFor(Coupon $coupon, float $subtotal): float
    {
        $discount = $coupon->type->apply($subtotal, (float) $coupon->value);

        if ($coupon->max_discount) {
            $discount = min($discount, (float) $coupon->max_discount);
        }

        return round(min($discount, $subtotal), 2);
    }

    public function redeem(Coupon $coupon, Booking $booking, float $amount): void
    {
        $coupon->usages()->create([
            'user_id'         => $booking->user_id,
            'booking_id'      => $booking->id,
            'discount_amount' => $amount,
        ]);

        $coupon->increment('used_count');
    }

    public function release(Booking $booking): void
    {
        if (! $booking->coupon_id) {
            return;
        }

        $booking->coupon()->first()?->decrement('used_count');
        $booking->coupon->usages()->where('booking_id', $booking->id)->delete();
    }

    private function appliesToTour(Coupon $coupon, Tour $tour): bool
    {
        $tours      = $coupon->applicable_tour_ids ?: [];
        $categories = $coupon->applicable_category_ids ?: [];

        if ($tours === [] && $categories === []) {
            return true;   // site-wide code
        }

        return in_array($tour->id, $tours, false) || in_array($tour->tour_category_id, $categories, false);
    }
}
