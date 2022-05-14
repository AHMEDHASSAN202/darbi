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


//dashboard settings
Route::group([
    'prefix' => 'dashboard/settings',
    'middleware' => ['auth:admin_api', 'permission:manage-settings']
], function () {
    Route::get(''           , 'SettingController@index');
    Route::post(''          , 'SettingController@update');
});


Route::get('init'           , 'InitController@index');
Route::get('start-up-images', 'StartUpImageController@index');

Route::get('countries'      , 'CountryController@index');
Route::get('cities'         , 'CityController@index');
Route::get('region'         , 'RegionController@index');
