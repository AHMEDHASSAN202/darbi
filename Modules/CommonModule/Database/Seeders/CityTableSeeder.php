<?php

namespace Modules\CommonModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $am = Country::where('code', 'AE')->first();
        $su = Country::where('code', 'SA')->first();

        $cities = [
            ['country_id' => $am->_id, 'name' => ['en' => 'Abu Dhabi', 'ar' => 'Abu Dhabi'], 'code' => 'ADH', 'is_active' => true],
            ['country_id' => $am->_id, 'name' => ['en' => 'Ajman', 'ar' => 'Ajman'], 'code' => 'AJ', 'is_active' => true],
            ['country_id' => $am->_id, 'name' => ['en' => 'Al Fujayrah', 'ar' => 'Al Fujayrah'], 'code' => 'FU', 'is_active' => true],
            ['country_id' => $am->_id, 'name' => ['en' => 'Ash Shariqah', 'ar' => 'Ash Shariqah'], 'code' => 'SH', 'is_active' => true],
            ['country_id' => $am->_id, 'name' => ['en' => 'Dubai', 'ar' => 'Dubai'], 'code' => 'DU', 'is_active' => true],
            ['country_id' => $am->_id, 'name' => ['en' => "R'as al Khaymah", 'ar' => "Ra's al Khaymah"], 'code' => 'RK', 'is_active' => true],
            ['country_id' => $am->_id, 'name' => ['en' => 'Umm al Qaywayn', 'ar' => 'Umm al Qaywayn'], 'code' => 'UQ', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Al Bahah', 'ar' => 'Al Bahah'], 'code' => 'BH', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Al Hudud ash Shamaliyah', 'ar' => 'Al Hudud ash Shamaliyah'], 'code' => 'HS', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Al Jawf', 'ar' => 'Al Jawf'], 'code' => 'JF', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Al Madinah', 'ar' => 'Al Madinah'], 'code' => 'MD', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Al Qasim', 'ar' => 'Al Qasim'], 'code' => 'QS', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Ar Riyad', 'ar' => 'Ar Riyad'], 'code' => 'RD', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Ash Sharqiyah (Eastern)', 'ar' => 'Ash Sharqiyah (Eastern)'], 'code' => 'AQ', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Asir', 'ar' => 'Ascir'], 'code' => 'AS', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Ha\'il', 'ar' => 'Ha\'il'], 'code' => 'HL', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Jizan', 'ar' => 'Jizan'], 'code' => 'JZ', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Makkah', 'ar' => 'Makkah'], 'code' => 'ML', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Najran', 'ar' => 'Najran'], 'code' => 'NR', 'is_active' => true],
            ['country_id' => $su->_id, 'name' => ['en' => 'Tabuk', 'ar' => 'Tabuk'], 'code' => 'TB', 'is_active' => true]
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
