<?php

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



//notifications routes
Route::group([
    'prefix'    => 'notifications',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''                    , 'NotificationController@index');
    Route::get('{notification}'      , 'NotificationController@show');
    Route::post(''                   , 'NotificationController@store');
    Route::put('{notification}'      , 'NotificationController@update');
    Route::delete('{notification}'   , 'NotificationController@destroy');
});
