<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ReviewStatus;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    protected $model = \App\Models\Review::class;

    public function definition(): array
    {
        return [
            'uuid'                 => Str::uuid(),
            'tour_id'              => Tour::factory(),
            'user_id'              => User::factory(),
            'reviewer_name'        => fake()->name(),
            'rating'               => fake()->numberBetween(3, 5),
            'title'                => fake()->sentence(4),
            'comment'              => fake()->paragraph(3),
            'status'               => ReviewStatus::Pending,
            'is_verified_purchase' => false,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => [
            'status'      => ReviewStatus::Approved,
            'approved_at' => now(),
        ]);
    }
}
