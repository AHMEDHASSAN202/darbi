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


//branches routes
Route::group([
    'prefix'    => 'regions',
    'middleware'=> ['auth:vendor_api', 'type:car', 'active_vendor']
], function () {
    Route::get(''                  , 'RegionController@index');
    Route::post(''                 , 'RegionController@store');
    Route::get('{region}'          , 'RegionController@find');
    Route::put('{region}'          , 'RegionController@update');
    Route::delete('{region}'       , 'RegionController@destroy');
});
