<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingSeeder::class,
            LocalizationSeeder::class,
            GeoSeeder::class,
            CmsSeeder::class,
            CatalogSeeder::class,
            HomeFeatureSeeder::class,
        ]);

        if (app()->environment('local', 'staging')) {
            $this->call(DemoDataSeeder::class);
        }
    }
}
