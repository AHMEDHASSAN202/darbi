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


//car routes
Route::group([
    'prefix'    => 'cars',
    'namespace' => 'User'
], function () {
    Route::get(''               , 'CarController@index');
    Route::get('{car}'          , 'CarController@show');
    Route::get('{car}/plugins'  , 'PluginController@findAllPluginByCar');
});



//yacht routes
Route::group([
    'prefix'  => 'yachts',
    'namespace' => 'User'
], function () {
    Route::get(''               , 'YachtController@index');
    Route::get('{yacht}'        , 'YachtController@show');
});


//brand routes
Route::group([
    'prefix'    => 'brands',
    'namespace' => 'User'
], function () {
    Route::get(''               , 'BrandController@index');
});
