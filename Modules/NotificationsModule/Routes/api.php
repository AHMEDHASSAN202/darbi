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

//notification routes
Route::group([
    'prefix'     => 'notifications',
    'namespace'  => 'User'
], function () {
    Route::get(''               , 'NotificationController@findAll')->middleware('auth:api');
    Route::post('send'           , 'NotificationController@send');
    Route::post('send-all'       , 'NotificationController@sendAll');
});



Route::group([
    'prefix'     => 'test/notifications',
    'namespace'  => 'User'
], function () {
    Route::get('send'               , 'TestNotificationController@send');
    Route::get('send-all'           , 'TestNotificationController@sendAll');
});
