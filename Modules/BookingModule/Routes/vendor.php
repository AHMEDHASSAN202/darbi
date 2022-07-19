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
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                       , 'BookingController@index');
    Route::get('{booking}'              , 'BookingController@show');
    Route::post('{booking}/cancel'      , 'BookingController@cancel');
    Route::post('{booking}/accept'      , 'BookingController@accept');
    Route::post('{booking}/paid'        , 'BookingController@paid');
    Route::post('{booking}/complete'    , 'BookingController@complete');
});


//vendor statistics
Route::group([
    'prefix'    => 'bookings/statistics/find',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                       , 'BookingStatisticController');
});



//vendor transactions
Route::group([
    'prefix'    => 'transactions',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                       , 'BookingPaymentTransactionController@index');
});
