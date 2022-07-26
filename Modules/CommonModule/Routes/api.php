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
    Route::get('regions'            , 'RegionController@index');
    Route::get('locations/find'     , 'LocationController@find');
});
