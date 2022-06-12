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
    'middleware' => 'auth:vendor_api',
    'namespace'  => 'Profile'
], function () {
    Route::get(''                       , 'VendorProfileController@getProfile');
    Route::put(''                       , 'VendorProfileController@updateProfile');
});


//vendor profile
Route::group([
    'prefix'     => 'vendor-profile',
    'middleware' => 'auth:vendor_api',
    'namespace'  => 'Profile'
], function () {
    Route::get(''                       , 'VendorProfileController@getVendor');
    Route::put(''                       , 'VendorProfileController@updateVendor');
});
