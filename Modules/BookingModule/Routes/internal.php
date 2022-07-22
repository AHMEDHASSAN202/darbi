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
], function () {
    Route::post('timeout'               , 'BookingController@timeout');
    Route::post('reminder'              , 'BookingController@reminder');
});
