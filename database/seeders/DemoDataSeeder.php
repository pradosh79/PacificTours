<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Enums\TourStatus;
use App\Models\Testimonial;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Local/staging demo content so the dashboard, search and reports have
 * something to show at the first run. Never seeded in production.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['manager@pacifictours.ca',  RoleName::Manager],
            ['sales@pacifictours.ca',    RoleName::SalesExecutive],
            ['operator@pacifictours.ca', RoleName::TourOperator],
        ] as [$email, $role]) {
            $user = User::firstOrCreate(['email' => $email], [
                'uuid'              => Str::uuid(),
                'first_name'        => Str::title(Str::before($email, '@')),
                'last_name'         => 'Demo',
                'password'          => Hash::make('Password!2026'),
                'email_verified_at' => now(),
            ]);
            $user->syncRoles([$role->value]);
        }

        $customers = User::factory()->count(25)->create();
        $customers->each(fn (User $u) => $u->assignRole(RoleName::Customer->value));

        $tours = Tour::factory()
            ->count(18)
            ->recycle(TourCategory::all())
            ->create(['status' => TourStatus::Published, 'published_at' => now()]);

        $tours->each(function (Tour $tour): void {
            foreach (range(1, $tour->duration_days) as $day) {
                $tour->itineraries()->create([
                    'day_number'  => $day,
                    'title'       => "Day {$day}",
                    'description' => 'Sample itinerary copy — replace from Admin → Tours.',
                    'meals'       => 'Breakfast',
                ]);
            }

            foreach (['Hotel pickup and drop-off', 'Licensed guide', 'All park fees'] as $i => $line) {
                $tour->inclusions()->create(['type' => 'included', 'content' => $line, 'sort_order' => $i]);
            }

            foreach (['Gratuities', 'Travel insurance'] as $i => $line) {
                $tour->inclusions()->create(['type' => 'excluded', 'content' => $line, 'sort_order' => $i]);
            }

            foreach (range(0, 11) as $week) {
                $tour->departures()->create([
                    'start_date'  => now()->addWeeks($week + 1)->startOfWeek()->addDays(2),
                    'end_date'    => now()->addWeeks($week + 1)->startOfWeek()->addDays(1 + $tour->duration_days),
                    'seats_total' => $tour->max_seats ?: 20,
                    'status'      => 'open',
                ]);
            }
        });

        foreach (range(1, 6) as $i) {
            Testimonial::create([
                'name'        => fake()->name(),
                'designation' => fake()->jobTitle(),
                'rating'      => fake()->numberBetween(4, 5),
                'content'     => fake()->paragraph(3),
                'sort_order'  => $i,
            ]);
        }
    }
}
