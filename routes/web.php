<?php

use Illuminate\Support\Facades\Route;
use MongoDB\BSON\ObjectId;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('health-check', function () {
    return 'GOOD';
});


Route::get("j", function () {
    ini_set('MAX_EXECUTION_TIME', -1);
    ini_set('memory_limit', '-1');
    $countries = json_decode(\Illuminate\Support\Facades\File::get(public_path("json/countries-states.json")), true);
    foreach ($countries as $country) {
        if (!in_array($country['iso2'], ["SA", "AE", "QA"])) {
            $c = [
                'name'      => ['ar' => $country['name'], 'en' => $country['name']],
                'code'      => $country['iso2'],
                'iso3'      => $country['iso3'],
                'capital'   => $country['capital'],
                'calling_code'  => $country['phone_code'],
                'currency_code' => $country['currency'],
                'currency'      => $country['currency_name'],
                'is_active'     => true,
                'image'         => ''
            ];
            $cy = \Modules\CommonModule\Entities\Country::create($c);
            $cities = [];
            foreach ($country['states'] as $state) {
                $cities[] = [
                    'name'          => ['ar' => $state['name'], 'en' => $state['name']],
                    'country_id'    => new ObjectId($cy->_id),
                    'country_code'  => $cy->code,
                    'code'          => $state['state_code'],
                    'is_active'     => true,
                    'lat'           => (float)$state['latitude'],
                    'lng'           => (float)$state['longitude'],
                    'created_at'    => new \MongoDB\BSON\UTCDateTime(),
                    'updated_at'    => new \MongoDB\BSON\UTCDateTime()
                ];
            }
            if (!empty($cities)) {
                \Modules\CommonModule\Entities\City::insert($cities);
            }
        }
    }
});
