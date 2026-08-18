<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\HomeFeature;
use Illuminate\Database\Seeder;

class HomeFeatureSeeder extends Seeder
{
    public function run(): void
    {
        // Six items shown on the Vancouver homepage design.
        $features = [
            ['icon' => 'users',  'title' => 'Small Group Experience',
             'description' => 'Travel in small groups for a more personal, relaxed, and enjoyable tour experience with dedicated attention from our local guides.'],
            ['icon' => 'award',  'title' => 'Private Custom Tours',
             'description' => 'We can create a personalised British Columbia sightseeing itinerary tailored to your interests, schedule and pace.'],
            ['icon' => 'shield', 'title' => 'Safe & Reliable',
             'description' => 'Travel with confidence through trusted guides, comfortable transportation, and reliable service, every time.'],
            ['icon' => 'anchor', 'title' => 'Cruise Passenger Excursions',
             'description' => 'Convenient sightseeing tours designed for cruise ship visitors arriving in Vancouver who want to maximise their time exploring British Columbia.'],
            ['icon' => 'clock',  'title' => 'Flexible Service',
             'description' => 'Ideal for families, visitors, cruise passengers, and corporate groups.'],
            ['icon' => 'car',    'title' => 'Mercedes-Benz Sprinter transportation',
             'description' => 'Professional commercial driver with extensive BC experience.'],
        ];

        foreach ($features as $i => $data) {
            HomeFeature::updateOrCreate(
                ['title' => $data['title']],
                $data + ['sort_order' => $i, 'is_active' => true]
            );
        }
    }
}
