<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    protected $model = \App\Models\Booking::class;

    public function definition(): array
    {
        $tour     = Tour::inRandomOrder()->first() ?? Tour::factory()->create();
        $adults   = fake()->numberBetween(1, 4);
        $subtotal = round((float) $tour->base_price * $adults, 2);

        return [
            'uuid'                => Str::uuid(),
            'booking_number'      => 'PT-'.now()->year.'-'.fake()->unique()->numerify('######'),
            'tour_id'             => $tour->id,
            'user_id'             => User::inRandomOrder()->value('id'),
            'customer_first_name' => fake()->firstName(),
            'customer_last_name'  => fake()->lastName(),
            'customer_email'      => fake()->safeEmail(),
            'customer_phone'      => fake()->numerify('+1 604 ### ####'),
            'travel_date'         => fake()->dateTimeBetween('now', '+4 months'),
            'adults'              => $adults,
            'children'            => fake()->numberBetween(0, 2),
            'adult_unit_price'    => $tour->base_price,
            'subtotal'            => $subtotal,
            'grand_total'         => $subtotal,
            'due_amount'          => $subtotal,
            'currency'            => 'CAD',
            'status'              => BookingStatus::Pending,
            'payment_status'      => PaymentStatus::Unpaid,
            'source'              => 'web',
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attrs) => [
            'status'         => BookingStatus::Confirmed,
            'payment_status' => PaymentStatus::Paid,
            'paid_amount'    => $attrs['grand_total'],
            'due_amount'     => 0,
            'confirmed_at'   => now(),
        ]);
    }
}
