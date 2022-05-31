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
    'namespace' => 'User'
], function () {
    Route::get(''                       , 'BookingController@findAllByUser')->middleware('auth:api');
    Route::post('rent'                  , 'BookingController@rent')->middleware('auth:api');
    Route::put('{bookingId}'            , 'BookingController@addBookDetails')->middleware('auth:api');
    Route::get('{bookingId}'            , 'BookingController@find')->middleware('auth:api');
    Route::post('{bookingId}/cancel'    , 'BookingController@cancel')->middleware('auth:api');
    Route::post('{bookingId}/checkout'  , 'BookingController@checkout')->middleware('auth:api');
});
