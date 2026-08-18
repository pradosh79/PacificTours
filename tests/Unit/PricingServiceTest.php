<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DTOs\BookingData;
use App\Enums\DepositType;
use App\Enums\DiscountType;
use App\Models\Coupon;
use App\Models\Tour;
use App\Services\PricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingServiceTest extends TestCase
{
    use RefreshDatabase;

    private PricingService $pricing;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pricing = app(PricingService::class);
    }

    public function test_it_multiplies_unit_prices_by_head_count(): void
    {
        $tour = Tour::factory()->create([
            'base_price'     => 200, 'child_price' => 120, 'infant_price' => 0,
            'discount_type'  => DiscountType::None,
            'tax_percentage' => 0, 'service_fee' => 0,
            'deposit_type'   => DepositType::Disabled,
        ]);

        $quote = $this->pricing->quote($tour, $this->data($tour, adults: 2, children: 1, infants: 1));

        $this->assertSame(520.0, $quote->subtotal);
        $this->assertSame(520.0, $quote->total);
    }

    public function test_percentage_discount_applies_before_tax(): void
    {
        $tour = Tour::factory()->create([
            'base_price' => 1000, 'discount_type' => DiscountType::Percentage, 'discount_value' => 10,
            'tax_percentage' => 5, 'service_fee' => 0, 'deposit_type' => DepositType::Disabled,
        ]);

        $quote = $this->pricing->quote($tour, $this->data($tour, adults: 1));

        $this->assertSame(100.0, $quote->tourDiscount);   // 10% of 1000
        $this->assertSame(45.0, $quote->tax);             // 5% of 900, not of 1000
        $this->assertSame(945.0, $quote->total);
    }

    public function test_coupon_stacks_after_the_tour_discount_and_respects_its_cap(): void
    {
        $tour = Tour::factory()->create([
            'base_price' => 1000, 'discount_type' => DiscountType::None,
            'tax_percentage' => 0, 'service_fee' => 0, 'deposit_type' => DepositType::Disabled,
        ]);

        $coupon = Coupon::factory()->create([
            'type' => 'percentage', 'value' => 25, 'max_discount' => 100, 'is_active' => true,
        ]);

        $quote = $this->pricing->quote($tour, $this->data($tour, adults: 1), $coupon);

        // 25% of 1000 is 250, but the coupon caps the benefit at 100.
        $this->assertSame(100.0, $quote->couponDiscount);
        $this->assertSame(900.0, $quote->total);
    }

    public function test_deposit_determines_the_amount_payable_now(): void
    {
        $tour = Tour::factory()->create([
            'base_price' => 1000, 'discount_type' => DiscountType::None,
            'tax_percentage' => 0, 'service_fee' => 0,
            'deposit_type' => DepositType::Percentage, 'deposit_value' => 25,
        ]);

        $quote = $this->pricing->quote($tour, $this->data($tour, adults: 1, deposit: true));

        $this->assertSame(250.0, $quote->deposit);
        $this->assertSame(250.0, $quote->payableNow());
        $this->assertSame(1000.0, $quote->total);
    }

    public function test_totals_are_rounded_to_two_decimals(): void
    {
        $tour = Tour::factory()->create([
            'base_price' => 99.99, 'discount_type' => DiscountType::Percentage, 'discount_value' => 7.5,
            'tax_percentage' => 5, 'service_fee' => 0, 'deposit_type' => DepositType::Disabled,
        ]);

        $quote = $this->pricing->quote($tour, $this->data($tour, adults: 3));

        $this->assertSame($quote->total, round($quote->total, 2));
    }

    private function data(Tour $tour, int $adults = 1, int $children = 0, int $infants = 0, bool $deposit = false): BookingData
    {
        return BookingData::fromArray([
            'tour_id'             => $tour->id,
            'travel_date'         => now()->addMonth()->toDateString(),
            'adults'              => $adults,
            'children'            => $children,
            'infants'             => $infants,
            'pay_deposit'         => $deposit,
            'customer_first_name' => 'Test',
            'customer_email'      => 'test@example.com',
        ]);
    }
}
