<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TourDepartureFactory extends Factory
{
    protected $model = \App\Models\TourDeparture::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 week', '+4 months');

        return [
            'uuid'         => Str::uuid(),
            'tour_id'      => Tour::factory(),
            'start_date'   => $start,
            'end_date'     => (clone $start)->modify('+2 days'),
            'seats_total'  => 20,
            'seats_booked' => 0,
            'seats_blocked'=> 0,
            'status'       => 'open',
        ];
    }

    public function nearlyFull(int $remaining = 1): static
    {
        return $this->state(fn (array $a) => ['seats_booked' => $a['seats_total'] - $remaining]);
    }

    public function departed(): static
    {
        return $this->state(fn () => [
            'start_date' => now()->subWeek(),
            'end_date'   => now()->subDays(5),
        ]);
    }
}
