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
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''               , 'PluginController@index');
});


//plugins routes
Route::group([
    'prefix'    => 'extras',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''               , 'ExtraController@index');
    Route::post(''              , 'ExtraController@store');
    Route::get('{extra}'        , 'ExtraController@show');
    Route::put('{extra}'        , 'ExtraController@update');
    Route::delete('{extra}'     , 'ExtraController@destroy');
});


//cars routes
Route::group([
    'prefix'    => 'cars',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''               , 'CarController@index');
    Route::post(''              , 'CarController@store');
    Route::get('{car}'          , 'CarController@show');
    Route::put('{car}'          , 'CarController@update');
    Route::delete('{car}'       , 'CarController@destroy');
    Route::delete('{car}/images/{index}'  , 'CarController@deleteImage');
});


//yachts routes
Route::group([
    'prefix'    => 'yachts',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                 , 'YachtController@index');
    Route::post(''                , 'YachtController@store');
    Route::get('{yacht}'          , 'YachtController@show');
    Route::put('{yacht}'          , 'YachtController@update');
    Route::delete('{yacht}'       , 'YachtController@destroy');
    Route::delete('{yacht}/images/{index}'  , 'YachtController@deleteImage');
});



//brands routes
Route::group([
    'prefix'    => 'brands',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                 , 'BrandController@index');
});



//models routes
Route::group([
    'prefix'    => 'models',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                 , 'ModelController@index');
});



//ports routes
Route::group([
    'prefix'    => 'ports',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                 , 'PortController@index');
});



//branches routes
Route::group([
    'prefix'    => 'branches',
    'middleware'=> ['auth:vendor_api']
], function () {
    Route::get(''                  , 'BranchController@index');
    Route::post(''                 , 'BranchController@store');
    Route::get('{branch}'          , 'BranchController@show');
    Route::put('{branch}'          , 'BranchController@update');
    Route::delete('{branch}'       , 'BranchController@destroy');
    Route::delete('{branch}/images/{index}'  , 'BranchController@deleteImage');
});
