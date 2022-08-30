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
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Abu Dhabi', 'ar' => 'أبو ظبي'], 'code' => 'ADH', 'is_active' => true, 'lat' => 24.453884, 'lng' => 24.453884],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Ajman', 'ar' => 'عجمان'], 'code' => 'AJ', 'is_active' => true, 'lat' => 25.405216, 'lng' => 25.405216],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Al Fujayrah', 'ar' => 'الفجيرة'], 'code' => 'FU', 'is_active' => true, 'lat' => 21.509020, 'lng' => 39.182270],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Ash Shariqah', 'ar' => 'الشارقة'], 'code' => 'SH', 'is_active' => true, 'lat' => 25.107844403965164, 'lng' => 55.75967385162665],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Dubai', 'ar' => 'دبي'], 'code' => 'DU', 'is_active' => true, 'lat' => 25.171498860085066, 'lng' => 55.220580279889916],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => "R'as al Khaymah", 'ar' => "رأس الخيمة"], 'code' => 'RK', 'is_active' => true, 'lat' => 25.717544287013343, 'lng' => 55.946784430591144],
            ['country_id' => new ObjectId($am->_id), 'country_code'  => $am->code, 'name' => ['en' => 'Umm al Qaywayn', 'ar' => 'أم القيوين'], 'code' => 'UQ', 'is_active' => true, 'lat' => 25.53200129161576, 'lng' => 55.7157458372726],

            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Bahah', 'ar' => 'الباحة'], 'code' => 'BH', 'is_active' => true, 'lat' => 20.02006079815387, 'lng' => 41.46321714556853],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Hudud ash Shamaliyah', 'ar' => 'الحدود الشمالية'], 'code' => 'HS', 'is_active' => true, 'lat' => 20.02006079815387, 'lng' => 41.46321714556853],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Jawf', 'ar' => 'الجوف'], 'code' => 'JF', 'is_active' => true, 'lat' => 41.46321714556853, 'lng' => 41.46321714556853],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Madinah', 'ar' => 'المدينة'], 'code' => 'MD', 'is_active' => true, 'lat' => 24.491005119006417, 'lng' => 39.620293794959764],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Al Qasim', 'ar' => 'القصيم'], 'code' => 'QS', 'is_active' => true, 'lat' => 26.57592309274165, 'lng' => 43.62897031323311],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Ar Riyad', 'ar' => 'الرياض'], 'code' => 'RD', 'is_active' => true, 'lat' => 24.701228775585445, 'lng' => 46.78952846764552],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Ash Sharqiyah (Eastern)', 'ar' => 'المنطقة الشرفية'], 'code' => 'AQ', 'is_active' => true, 'lat' => 23.300656672279672, 'lng' => 50.39750054651925],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Asir', 'ar' => 'عسير'], 'code' => 'AS', 'is_active' => true, 'lat' => 23.300656672279672, 'lng' => 50.39750054651925],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Ha\'il', 'ar' => 'حائل'], 'code' => 'HL', 'is_active' => true, 'lat' => 27.52801254947435, 'lng' => 41.66101426371683],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Jizan', 'ar' => 'جازان'], 'code' => 'JZ', 'is_active' => true, 'lat' => 27.52801254947435, 'lng' => 41.66101426371683],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Makkah', 'ar' => 'مكة'], 'code' => 'ML', 'is_active' => true, 'lat' => 21.4308438699227, 'lng' => 39.82662334397889],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Najran', 'ar' => 'نجران'], 'code' => 'NR', 'is_active' => true, 'lat' => 21.4308438699227, 'lng' => 39.82662334397889],
            ['country_id' => new ObjectId($su->_id), 'country_code'  => $su->code, 'name' => ['en' => 'Tabuk', 'ar' => 'تبوك'], 'code' => 'TB', 'is_active' => true, 'lat' => 21.4308438699227 , 'lng' => 39.82662334397889],

            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Ad Dawhah', 'ar' => 'الدوحة'], 'code' => 'DW', 'is_active' => true, 'lat' => 25.2854 , 'lng' => 51.5310],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Ghuwayriyah', 'ar' => 'الغويرية'], 'code' => 'GW', 'is_active' => true, 'lat' => 25.8448 , 'lng' => 51.2454],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Jumayliyah', 'ar' => 'الجميلية'], 'code' => 'JM', 'is_active' => true, 'lat' => 25.6219 , 'lng' => 51.0836],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Khawr', 'ar' => 'الخور'], 'code' => 'KR', 'is_active' => true, 'lat' => 25.6804 , 'lng' => 51.4969],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Al Wakrah', 'ar' => 'الوكرة'], 'code' => 'WK', 'is_active' => true, 'lat' => 25.1659 , 'lng' => 51.5976],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Ar Rayyan', 'ar' => 'الريان'], 'code' => 'RN', 'is_active' => true, 'lat' => 25.2862 , 'lng' => 51.4204],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Jarayan al Batinah', 'ar' => 'جريان البطنة'], 'code' => 'JB', 'is_active' => true, 'lat' => 25.1166 , 'lng' => 51.1611],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Madinat ash Shamal', 'ar' => 'بلدية الشمال'], 'code' => 'MS', 'is_active' => true, 'lat' => 26.1183 , 'lng' => 51.2157],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Umm Sa\'id', 'ar' => 'مسيعيد'], 'code' => 'UD', 'is_active' => true, 'lat' => 24.9909 , 'lng' => 51.5493],
            ['country_id' => new ObjectId($qa->_id), 'country_code'  => $qa->code, 'name' => ['en' => 'Umm Salal', 'ar' => 'أم صلال'], 'code' => 'UL', 'is_active' => true, 'lat' => 25.3984 , 'lng' => 51.4247],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
