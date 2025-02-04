<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('init'                   , 'InitController@index');


Route::group([
    'namespace' => 'Location'
], function () {
    Route::get('countries'          , 'CountryController@index');
    Route::get('cities'             , 'CityController@index');
    Route::get('cities/{city}'      , 'CityController@find');
    Route::get('regions'            , 'RegionController@index');
    Route::get('regions/nearme'     , 'RegionController@findRegionsByNorthEastAndSouthWest');
    Route::get('regions/find'       , 'RegionController@findRegionByLatAndLng');
    Route::get('locations/find'     , 'LocationController@find');
});


Route::get('currencies'             , 'CurrencyController');
Route::get('car-types'              , 'CarTypeController');
