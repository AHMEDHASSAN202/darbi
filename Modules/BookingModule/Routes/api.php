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
    Route::get(''               , 'BookingController@findAllByUser');
    Route::get('{bookingId}'    , 'BookingController@find');
});
