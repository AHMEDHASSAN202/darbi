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


//plugins routes
Route::group([
    'prefix'    => 'plugins',
    'middleware' => ['auth:admin_api']
], function () {
    Route::get(''               , 'PluginController@index');
    Route::get('{plugin}'       , 'PluginController@show');
    Route::post(''              , 'PluginController@store');
    Route::put('{plugin}'       , 'PluginController@update');
    Route::delete('{plugin}'    , 'PluginController@destroy');
});


//ports routes
Route::group([
    'prefix'    => 'ports',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''             , 'PortController@index');
    Route::get('{port}'       , 'PortController@show');
    Route::post(''            , 'PortController@store');
    Route::put('{port}'       , 'PortController@update');
    Route::delete('{port}'    , 'PortController@destroy');
});
