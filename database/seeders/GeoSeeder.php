<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GeoSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Canada',        'iso2' => 'CA', 'iso3' => 'CAN', 'phone_code' => '+1',  'currency_code' => 'CAD'],
            ['name' => 'United States', 'iso2' => 'US', 'iso3' => 'USA', 'phone_code' => '+1',  'currency_code' => 'USD'],
            ['name' => 'Mexico',        'iso2' => 'MX', 'iso3' => 'MEX', 'phone_code' => '+52', 'currency_code' => 'MXN'],
        ];

        foreach ($countries as $row) {
            Country::updateOrCreate(['iso2' => $row['iso2']], $row + ['slug' => Str::slug($row['name'])]);
        }

        $canada = Country::where('iso2', 'CA')->first();

        $cities = ['Vancouver', 'Victoria', 'Whistler', 'Banff', 'Calgary', 'Toronto', 'Quebec City', 'Jasper'];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['country_id' => $canada->id, 'slug' => Str::slug($city)],
                ['name' => $city]
            );
        }

        $destinations = [
            ['name' => 'Vancouver & Sea to Sky', 'city' => 'Vancouver', 'featured' => true],
            ['name' => 'Vancouver Island',       'city' => 'Victoria',  'featured' => true],
            ['name' => 'Canadian Rockies',       'city' => 'Banff',     'featured' => true],
            ['name' => 'Whistler',               'city' => 'Whistler',  'featured' => false],
        ];

        foreach ($destinations as $row) {
            Destination::updateOrCreate(
                ['slug' => Str::slug($row['name'])],
                [
                    'country_id'        => $canada->id,
                    'city_id'           => City::where('slug', Str::slug($row['city']))->value('id'),
                    'name'              => $row['name'],
                    'short_description' => "Guided departures across {$row['name']}.",
                    'is_featured'       => $row['featured'],
                    'is_active'         => true,
                ]
            );
        }
    }
}
