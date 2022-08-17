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
    Route::get('{car}/share'    , 'CarController@share');
});



//yacht routes
Route::group([
    'prefix'  => 'yachts',
    'namespace' => 'User'
], function () {
    Route::get(''               , 'YachtController@index');
    Route::get('{yacht}'        , 'YachtController@show');
    Route::get('{yacht}/share'  , 'YachtController@share');
});


//brand routes
Route::group([
    'prefix'    => 'brands',
    'namespace' => 'User'
], function () {
    Route::get(''               , 'BrandController@index');
});



//brand routes
Route::group([
    'prefix'    => 'ports',
    'namespace' => 'User'
], function () {
    Route::get(''               , 'PortController@index');
});



Route::group([
    'prefix'    => 'private-jets',
    'namespace' => 'User'
], function () {
    Route::get(''               , 'PrivateJetController@index');
});
