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


//vendor booking routes
Route::group([
    'prefix'    => 'bookings',
    'namespace' => 'Vendor'
], function () {
    Route::get(''                       , 'BookingController@idnex')->middleware('auth:api');
    Route::get('{booking}'              , 'BookingController@show')->middleware('auth:api');
});
