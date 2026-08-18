<?php

declare(strict_types=1);

namespace Tests\Feature\Booking;

use App\Exceptions\CouponException;
use App\Models\Coupon;
use App\Models\Tour;
use App\Models\User;
use App\Services\CouponService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_expired_coupon_is_rejected(): void
    {
        $coupon = Coupon::factory()->create(['expires_at' => now()->subDay(), 'is_active' => true]);

        $this->expectException(CouponException::class);

        app(CouponService::class)->validate($coupon->code, Tour::factory()->create(), 500);
    }

    public function test_a_coupon_below_its_minimum_spend_is_rejected(): void
    {
        $coupon = Coupon::factory()->create(['min_spend' => 1000, 'is_active' => true]);

        $this->expectException(CouponException::class);

        app(CouponService::class)->validate($coupon->code, Tour::factory()->create(), 500);
    }

    public function test_a_coupon_that_hit_its_global_limit_is_rejected(): void
    {
        $coupon = Coupon::factory()->create(['usage_limit' => 2, 'used_count' => 2, 'is_active' => true]);

        $this->expectException(CouponException::class);

        app(CouponService::class)->validate($coupon->code, Tour::factory()->create(), 500);
    }

    public function test_a_coupon_restricted_to_other_tours_is_rejected(): void
    {
        $allowed = Tour::factory()->create();
        $other   = Tour::factory()->create();

        $coupon = Coupon::factory()->create([
            'applicable_tour_ids' => [$allowed->id],
            'is_active'           => true,
        ]);

        $this->expectException(CouponException::class);

        app(CouponService::class)->validate($coupon->code, $other, 500);
    }

    public function test_per_user_limits_are_counted_separately_from_the_global_limit(): void
    {
        $user   = User::factory()->create();
        $coupon = Coupon::factory()->create(['usage_limit_per_user' => 1, 'is_active' => true]);

        $coupon->usages()->create(['user_id' => $user->id, 'discount_amount' => 50]);

        $this->expectException(CouponException::class);

        app(CouponService::class)->validate($coupon->code, Tour::factory()->create(), 500, $user);
    }

    public function test_a_valid_coupon_passes_and_returns_the_model(): void
    {
        $coupon = Coupon::factory()->create(['is_active' => true, 'min_spend' => 0]);

        $this->assertTrue(
            $coupon->is(app(CouponService::class)->validate($coupon->code, Tour::factory()->create(), 500))
        );
    }
}
