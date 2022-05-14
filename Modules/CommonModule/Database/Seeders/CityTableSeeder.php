<?php

namespace Modules\CommonModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CommonModule\Entities\City;

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

        $cities = [
            ['country_code' => 'AE', 'name' => 'Abu Dhabi', 'code' => 'ADH', 'is_active' => true],
            ['country_code' => 'AE', 'name' => 'Ajman', 'code' => 'AJ', 'is_active' => true],
            ['country_code' => 'AE', 'name' => 'Al Fujayrah', 'code' => 'FU', 'is_active' => true],
            ['country_code' => 'AE', 'name' => 'Ash Shariqah', 'code' => 'SH', 'is_active' => true],
            ['country_code' => 'AE', 'name' => 'Dubai', 'code' => 'DU', 'is_active' => true],
            ['country_code' => 'AE', 'name' => "R'as al Khaymah", 'code' => 'RK', 'is_active' => true],
            ['country_code' => 'AE', 'name' => 'Umm al Qaywayn', 'code' => 'UQ', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Ad Daqahliyah', 'code' => 'DHY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Bahr al Ahmar', 'code' => 'BAM', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Buhayrah', 'code' => 'BHY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Fayyum', 'code' => 'FYM', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Gharbiyah', 'code' => 'GBY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Iskandariyah', 'code' => 'IDR', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Isma\'iliyah', 'code' => 'IML', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Jizah', 'code' => 'JZH', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Minufiyah', 'code' => 'MFY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Minya', 'code' => 'MNY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Qahirah', 'code' => 'QHR', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Qalyubiyah', 'code' => 'QLY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Al Wadi al Jadid', 'code' => 'WJD', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Ash Sharqiyah', 'code' => 'SHQ', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'As Suways', 'code' => 'SWY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Aswan', 'code' => 'ASW', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Asyut', 'code' => 'ASY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Bani Suwayf', 'code' => 'BSW', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Bur Sa\'id', 'code' => 'BSD', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Dumyat', 'code' => 'DMY', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Janub Sina\'', 'code' => 'JNS', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Kafr ash Shaykh', 'code' => 'KSH', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Matruh', 'code' => 'MAT', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Qina', 'code' => 'QIN', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Shamal Sina\'', 'code' => 'SHS', 'is_active' => true],
            ['country_code' => 'EG', 'name' => 'Suhaj', 'code' => 'SUH', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Al Bahah', 'code' => 'BH', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Al Hudud ash Shamaliyah', 'code' => 'HS', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Al Jawf', 'code' => 'JF', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Al Madinah', 'code' => 'MD', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Al Qasim', 'code' => 'QS', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Ar Riyad', 'code' => 'RD', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Ash Sharqiyah (Eastern)', 'code' => 'AQ', 'is_active' => true],
            ['country_code' => 'SA', 'name' => '\'Asir', 'code' => 'AS', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Ha\'il', 'code' => 'HL', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Jizan', 'code' => 'JZ', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Makkah', 'code' => 'ML', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Najran', 'code' => 'NR', 'is_active' => true],
            ['country_code' => 'SA', 'name' => 'Tabuk', 'code' => 'TB', 'is_active' => true]
        ];

        foreach ($cities as $city) City::create($city);
    }
}
