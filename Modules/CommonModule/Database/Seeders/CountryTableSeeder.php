<?php

namespace Modules\CommonModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CommonModule\Entities\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Country::create(['name' => ['ar' => 'السعودية', 'en' => 'Saudi Arabia'], 'code' => 'SA', 'iso3' => 'SAU', 'capital' => 'Riyadh', 'calling_code' => '966', 'currency_code' => 'SAR', 'currency' => 'riyal', 'is_active' => true]);
        Country::create(['name' => ['ar' => 'الامارات', 'en' => 'United Arab Emirates'], 'code' => 'AE', 'iso3' => 'ARE', 'capital' => 'Abu Dhabi', 'calling_code' => '971', 'currency_code' => 'AED', 'currency' => 'UAE dirham', 'is_active' => true]);
        Country::create(['name' => ['ar' => 'قطر', 'en' => 'Qatar'], 'code' => 'QA', 'iso3' => 'QAT', 'capital' => 'Doha', 'calling_code' => '974', 'currency_code' => 'QAR', 'currency' => 'Qatari riyal', 'is_active' => true]);
    }
}
