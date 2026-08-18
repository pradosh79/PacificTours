<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TourCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Day Tours',        'icon' => 'sun'],
            ['name' => 'Multi-Day Tours',  'icon' => 'map'],
            ['name' => 'Wildlife & Nature','icon' => 'leaf'],
            ['name' => 'City & Culture',   'icon' => 'building'],
            ['name' => 'Adventure',        'icon' => 'mountain'],
            ['name' => 'Cruise Excursions','icon' => 'ship'],
            ['name' => 'Private Charters', 'icon' => 'star'],
        ];

        foreach ($categories as $i => $row) {
            TourCategory::updateOrCreate(
                ['slug' => Str::slug($row['name'])],
                $row + ['sort_order' => $i, 'is_active' => true]
            );
        }
    }
}
