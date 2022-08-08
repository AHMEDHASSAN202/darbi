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

//vendor auth
Route::group([
    'prefix'     => 'auth',
    'namespace'  => 'Auth'
], function () {
    Route::post('login'                 , 'AuthVendorController@login');
});


//user vendor profile
Route::group([
    'prefix'     => 'profile',
    'middleware' => ['auth:vendor_api', 'active_vendor'],
    'namespace'  => 'Profile'
], function () {
    Route::get(''                       , 'VendorProfileController@getProfile');
    Route::put(''                       , 'VendorProfileController@updateProfile');
});


Route::post('device-token'              , 'UserDeviceTokenController@storeDeviceToken')->middleware('auth:vendor_api');

//vendor profile
Route::group([
    'prefix'     => 'settings',
    'middleware' => ['auth:vendor_api', 'active_vendor'],
    'namespace'  => 'Settings'
], function () {
    Route::get(''                       , 'VendorSettingsController@getSettings');
    Route::put(''                       , 'VendorSettingsController@updateSettings');
});
