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


//plugin routes

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


//port routes
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


//brand routes
Route::group([
    'prefix'    => 'brands',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''              , 'BrandController@index');
    Route::get('{brand}'       , 'BrandController@show');
    Route::post(''             , 'BrandController@store');
    Route::put('{brand}'       , 'BrandController@update');
    Route::delete('{brand}'    , 'BrandController@destroy');
});


//model routes
Route::group([
    'prefix'    => 'models',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''             , 'ModelController@index');
    Route::get('assets'       , 'ModelController@assets');
    Route::get('{model}'      , 'ModelController@show');
    Route::post(''            , 'ModelController@store');
    Route::put('{model}'      , 'ModelController@update');
    Route::delete('{model}'   , 'ModelController@destroy');
    Route::delete('{model}/images/{index}'  , 'ModelController@deleteImage');
});



//vendor routes
Route::group([
    'prefix'    => 'vendors',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''             , 'VendorController@index');
    Route::get('{vendor}'     , 'VendorController@show');
    Route::post(''            , 'VendorController@store');
    Route::post('get-auth-token' , 'VendorController@authAsVendor');
    Route::put('{vendor}'     , 'VendorController@update');
    Route::put('{vendor}/toggle-active' , 'VendorController@toggleActive');
    Route::delete('{vendor}'  , 'VendorController@destroy');
});



//car routes
Route::group([
    'prefix'    => 'cars',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''             , 'CarController@index');
    Route::get('{car}'        , 'CarController@show');
    Route::delete('{car}'     , 'CarController@destroy');
});



//yacht routes
Route::group([
    'prefix'    => 'yachts',
    'middleware'=> ['auth:admin_api']
], function () {
    Route::get(''             , 'YachtController@index');
    Route::get('{yacht}'      , 'YachtController@show');
    Route::delete('{yacht}'   , 'YachtController@destroy');
});
