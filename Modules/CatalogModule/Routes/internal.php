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

//entity routes
Route::group([
    'prefix'    => 'entities',
], function () {
    Route::get('{entity}'               , 'EntityController@show');
    Route::put('{entity}/{state}'       , 'EntityController@updateState')->whereIn('state', \Modules\CatalogModule\Enums\EntityStatus::getTypes());
});




//vendor routes
Route::group([
    'prefix'    => 'vendors',
], function () {
    Route::get('{vendor}'               , 'VendorController@show');
});




//branches routes
Route::group([
    'prefix'    => 'branches',
], function () {
    Route::get('{branch}'               , 'BranchController@show');
});



//ports routes
Route::group([
    'prefix'    => 'ports',
], function () {
    Route::get('{port}'                 , 'PortController@show');
});
