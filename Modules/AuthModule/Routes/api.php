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
    'prefix' => 'dashboard/auth'
], function () {
    Route::post('login', 'AuthDashboardController@login');
});


//api/v1/vendor/auth
Route::group([
    'prefix' => 'vendor/auth'
], function () {
    Route::post('login', 'AuthVendorController@login');
});


//api/v1/vendor/auth
Route::group([
    'prefix' => 'user/auth'
], function () {

});
