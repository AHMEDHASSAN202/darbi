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


//common routes
Route::group([
    'prefix' => 'commons'
], function () {
    Route::get('countries'       , 'CountryController@index');
    Route::get('countries/{iso}' , 'CountryController@show');
});
