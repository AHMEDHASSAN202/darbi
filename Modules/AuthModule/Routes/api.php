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


//places routes
Route::group([
    'prefix'    => 'places'
], function () {
    Route::get(''               , 'SavedPlaceController@findAll');
});


//sign in routes
Route::post('signin'            , 'AuthController@signin')->middleware('throttle:auth');
Route::post('send-otp'          , 'AuthController@sendOtp')->middleware('throttle:auth');
Route::post('signin-with-otp'   , 'AuthController@signinWithOtp')->middleware('throttle:auth');


//profile
Route::get('profile'            , 'ProfileController@getProfile')->middleware('auth:api');
Route::put('profile'            , 'ProfileController@updateProfile')->middleware('auth:api');
//Route::put('profile/phone'      , 'ProfileController@updateProfilePhone')->middleware('auth:api');


//device token
Route::post('device-token'      , 'UserDeviceTokenController@storeDeviceToken')->middleware('auth:api');
