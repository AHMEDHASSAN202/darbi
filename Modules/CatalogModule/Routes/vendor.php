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
    'middleware'=> ['auth:vendor_api', 'active_vendor']
], function () {
    Route::get(''               , 'PluginController@index');
});


//plugins routes
Route::group([
    'prefix'    => 'extras',
    'middleware'=> ['auth:vendor_api', 'active_vendor']
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
    'middleware'=> ['auth:vendor_api', 'type:car', 'active_vendor']
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
    'middleware'=> ['auth:vendor_api', 'type:yacht', 'active_vendor']
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
    'middleware'=> ['auth:vendor_api', 'active_vendor']
], function () {
    Route::get(''                 , 'BrandController@index');
});



//models routes
Route::group([
    'prefix'    => 'models',
    'middleware'=> ['auth:vendor_api', 'active_vendor']
], function () {
    Route::get(''                 , 'ModelController@index');
});



//ports routes
Route::group([
    'prefix'    => 'ports',
    'middleware'=> ['auth:vendor_api', 'type:yacht', 'active_vendor']
], function () {
    Route::get(''                 , 'PortController@index');
});



//branches routes
Route::group([
    'prefix'    => 'branches',
    'middleware'=> ['auth:vendor_api', 'type:car', 'active_vendor']
], function () {
    Route::get(''                  , 'BranchController@index');
    Route::post(''                 , 'BranchController@store');
    Route::get('{branch}'          , 'BranchController@show');
    Route::put('{branch}'          , 'BranchController@update');
    Route::delete('{branch}'       , 'BranchController@destroy');
    Route::delete('{branch}/images/{index}'  , 'BranchController@deleteImage');
});



//villas routes
Route::group([
    'prefix'    => 'villas',
    'middleware'=> ['auth:vendor_api', 'type:villa', 'active_vendor']
], function () {
    Route::get(''                 , 'VillaController@index');
    Route::post(''                , 'VillaController@store');
    Route::get('{villa}'          , 'VillaController@show');
    Route::put('{villa}'          , 'VillaController@update');
    Route::delete('{villa}'       , 'VillaController@destroy');
    Route::delete('{villa}/images/{index}'  , 'VillaController@deleteImage');
});



//attributes routes
Route::group([
    'prefix'    => 'attributes',
    'middleware'=> ['auth:vendor_api', 'active_vendor']
], function () {
    Route::get(''                 , 'AttributeController@index');
});
