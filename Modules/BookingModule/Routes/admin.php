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


//booking routes
Route::group([
    'prefix'    => 'bookings',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''                       , 'BookingController@index');
    Route::get('{booking}'              , 'BookingController@show');
    Route::post('{booking}/cancel'      , 'BookingController@cancel');
});
