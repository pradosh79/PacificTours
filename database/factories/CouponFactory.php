<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CouponFactory extends Factory
{
    protected $model = \App\Models\Coupon::class;

    public function definition(): array
    {
        return [
            'code'                 => strtoupper(Str::random(8)),
            'name'                 => fake()->words(2, true).' offer',
            'type'                 => 'percentage',
            'value'                => 10,
            'min_spend'            => 0,
            'max_discount'         => null,
            'usage_limit'          => null,
            'usage_limit_per_user' => 1,
            'used_count'           => 0,
            'applicable_tour_ids'  => null,
            'applicable_category_ids' => null,
            'starts_at'            => now()->subDay(),
            'expires_at'           => now()->addMonth(),
            'is_active'            => true,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn () => ['expires_at' => now()->subDay()]);
    }

    public function fixed(float $value = 50): static
    {
        return $this->state(fn () => ['type' => 'fixed', 'value' => $value]);
    }

    public function exhausted(): static
    {
        return $this->state(fn () => ['usage_limit' => 1, 'used_count' => 1]);
    }
}
