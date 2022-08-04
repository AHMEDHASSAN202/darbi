<?php

namespace Modules\CommonModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

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
        $qa = Country::where('code', 'QA')->first();

        $cities = [
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Abu Dhabi', 'ar' => 'Abu Dhabi'], 'code' => 'ADH', 'is_active' => true, 'lat' => 24.453884, 'lng' => 24.453884],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Ajman', 'ar' => 'Ajman'], 'code' => 'AJ', 'is_active' => true, 'lat' => 25.405216, 'lng' => 25.405216],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Al Fujayrah', 'ar' => 'Al Fujayrah'], 'code' => 'FU', 'is_active' => true, 'lat' => 21.509020, 'lng' => 39.182270],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Ash Shariqah', 'ar' => 'Ash Shariqah'], 'code' => 'SH', 'is_active' => true, 'lat' => 25.107844403965164, 'lng' => 55.75967385162665],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Dubai', 'ar' => 'Dubai'], 'code' => 'DU', 'is_active' => true, 'lat' => 25.171498860085066, 'lng' => 55.220580279889916],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => "R'as al Khaymah", 'ar' => "Ra's al Khaymah"], 'code' => 'RK', 'is_active' => true, 'lat' => 25.717544287013343, 'lng' => 55.946784430591144],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Umm al Qaywayn', 'ar' => 'Umm al Qaywayn'], 'code' => 'UQ', 'is_active' => true, 'lat' => 25.53200129161576, 'lng' => 55.7157458372726],

            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Bahah', 'ar' => 'Al Bahah'], 'code' => 'BH', 'is_active' => true, 'lat' => 20.02006079815387, 'lng' => 41.46321714556853],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Hudud ash Shamaliyah', 'ar' => 'Al Hudud ash Shamaliyah'], 'code' => 'HS', 'is_active' => true, 'lat' => 20.02006079815387, 'lng' => 41.46321714556853],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Jawf', 'ar' => 'Al Jawf'], 'code' => 'JF', 'is_active' => true, 'lat' => 41.46321714556853, 'lng' => 41.46321714556853],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Madinah', 'ar' => 'Al Madinah'], 'code' => 'MD', 'is_active' => true, 'lat' => 24.491005119006417, 'lng' => 39.620293794959764],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Qasim', 'ar' => 'Al Qasim'], 'code' => 'QS', 'is_active' => true, 'lat' => 26.57592309274165, 'lng' => 43.62897031323311],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Ar Riyad', 'ar' => 'Ar Riyad'], 'code' => 'RD', 'is_active' => true, 'lat' => 24.701228775585445, 'lng' => 46.78952846764552],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Ash Sharqiyah (Eastern)', 'ar' => 'Ash Sharqiyah (Eastern)'], 'code' => 'AQ', 'is_active' => true, 'lat' => 23.300656672279672, 'lng' => 50.39750054651925],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Asir', 'ar' => 'Ascir'], 'code' => 'AS', 'is_active' => true, 'lat' => 23.300656672279672, 'lng' => 50.39750054651925],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Ha\'il', 'ar' => 'Ha\'il'], 'code' => 'HL', 'is_active' => true, 'lat' => 27.52801254947435, 'lng' => 41.66101426371683],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Jizan', 'ar' => 'Jizan'], 'code' => 'JZ', 'is_active' => true, 'lat' => 27.52801254947435, 'lng' => 41.66101426371683],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Makkah', 'ar' => 'Makkah'], 'code' => 'ML', 'is_active' => true, 'lat' => 21.4308438699227, 'lng' => 39.82662334397889],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Najran', 'ar' => 'Najran'], 'code' => 'NR', 'is_active' => true, 'lat' => 21.4308438699227, 'lng' => 39.82662334397889],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Tabuk', 'ar' => 'Tabuk'], 'code' => 'TB', 'is_active' => true, 'lat' => 21.4308438699227 , 'lng' => 39.82662334397889],

            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Ad Dawhah', 'ar' => 'Ad Dawhah'], 'code' => 'DW', 'is_active' => true, 'lat' => 25.2854 , 'lng' => 51.5310],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Ghuwayriyah', 'ar' => 'Al Ghuwayriyah'], 'code' => 'GW', 'is_active' => true, 'lat' => 25.8448 , 'lng' => 51.2454],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Jumayliyah', 'ar' => 'Al Jumayliyah'], 'code' => 'JM', 'is_active' => true, 'lat' => 25.6219 , 'lng' => 51.0836],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Khawr', 'ar' => 'Al Khawr'], 'code' => 'KR', 'is_active' => true, 'lat' => 25.6804 , 'lng' => 51.4969],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Wakrah', 'ar' => 'Al Wakrah'], 'code' => 'WK', 'is_active' => true, 'lat' => 25.1659 , 'lng' => 51.5976],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Ar Rayyan', 'ar' => 'Ar Rayyan'], 'code' => 'RN', 'is_active' => true, 'lat' => 25.2862 , 'lng' => 51.4204],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Jarayan al Batinah', 'ar' => 'Jarayan al Batinah'], 'code' => 'JB', 'is_active' => true, 'lat' => 25.1166 , 'lng' => 51.1611],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Madinat ash Shamal', 'ar' => 'Madinat ash Shamal'], 'code' => 'MS', 'is_active' => true, 'lat' => 26.1183 , 'lng' => 51.2157],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Umm Sa\'id', 'ar' => 'Umm Sa\'id'], 'code' => 'UD', 'is_active' => true, 'lat' => 24.9909 , 'lng' => 51.5493],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Umm Salal', 'ar' => 'Umm Salal'], 'code' => 'UL', 'is_active' => true, 'lat' => 25.3984 , 'lng' => 51.4247],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
