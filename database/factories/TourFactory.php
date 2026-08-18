<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\DepositType;
use App\Enums\DiscountType;
use App\Enums\TourStatus;
use App\Models\Destination;
use App\Models\TourCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TourFactory extends Factory
{
    protected $model = \App\Models\Tour::class;

    public function definition(): array
    {
        $title = Str::title(fake()->words(3, true)).' Tour';
        $days  = fake()->numberBetween(1, 10);
        $price = fake()->randomFloat(2, 89, 3200);

        return [
            'uuid'             => Str::uuid(),
            'code'             => 'PT-T-'.fake()->unique()->numerify('######'),
            'title'            => $title,
            'slug'             => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'tour_category_id' => TourCategory::inRandomOrder()->value('id') ?? TourCategory::factory(),
            'destination_id'   => Destination::inRandomOrder()->value('id'),
            'summary'          => fake()->sentence(14),
            'description'      => fake()->paragraphs(4, true),
            'duration_days'    => $days,
            'duration_nights'  => max(0, $days - 1),
            'base_price'       => $price,
            'child_price'      => round($price * 0.7, 2),
            'infant_price'     => 0,
            'sale_price'       => $price,
            'discount_type'    => DiscountType::None,
            'deposit_type'     => DepositType::Percentage,
            'deposit_value'    => 25,
            'tax_percentage'   => 5,
            'max_seats'        => fake()->numberBetween(8, 40),
            'min_booking'      => 1,
            'max_booking'      => 12,
            'currency'         => 'CAD',
            'status'           => TourStatus::Published,
            'is_featured'      => fake()->boolean(30),
            'is_popular'       => fake()->boolean(25),
            'published_at'     => now(),
        ];
    }
}
