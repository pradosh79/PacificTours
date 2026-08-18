<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Language;
use Illuminate\Database\Seeder;

class LocalizationSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Canadian Dollar', 'code' => 'CAD', 'symbol' => '$',   'exchange_rate' => 1,      'is_default' => true],
            ['name' => 'US Dollar',       'code' => 'USD', 'symbol' => 'US$', 'exchange_rate' => 0.73,   'is_default' => false],
            ['name' => 'Euro',            'code' => 'EUR', 'symbol' => '€',   'exchange_rate' => 0.68,   'is_default' => false],
        ] as $row) {
            Currency::updateOrCreate(['code' => $row['code']], $row);
        }

        foreach ([
            ['name' => 'English', 'code' => 'en', 'is_default' => true,  'is_active' => true],
            ['name' => 'Français', 'code' => 'fr', 'is_default' => false, 'is_active' => true],
        ] as $row) {
            Language::updateOrCreate(['code' => $row['code']], $row);
        }
    }
}
