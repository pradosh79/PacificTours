<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\HomeFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeFeatureFactory extends Factory
{
    protected $model = HomeFeature::class;

    public function definition(): array
    {
        return [
            'icon'        => fake()->randomElement(['check', 'shield', 'users', 'car', 'clock', 'award']),
            'title'       => fake()->sentence(3),
            'description' => fake()->sentence(12),
            'sort_order'  => fake()->numberBetween(0, 100),
            'is_active'   => true,
        ];
    }
}
