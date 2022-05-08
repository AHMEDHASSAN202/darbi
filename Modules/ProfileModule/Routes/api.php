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

Route::group([
    'prefix' => 'dashboard/profile',
    'middleware' => 'auth:admin_api'
], function () {
    Route::get('', 'AdminProfileController@getProfile');
    Route::put('', 'AdminProfileController@updateProfile');
});


Route::group([
    'prefix' => 'vendor/profile',
    'middleware' => 'auth:vendor_api'
], function () {
    Route::get('', 'VendorProfileController@getProfile');
    Route::put('', 'VendorProfileController@updateProfile');
    Route::put('info', 'VendorProfileController@updateInfo');
});
