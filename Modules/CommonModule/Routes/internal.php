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


//regions routes
Route::group([
    'prefix'    => 'regions',
], function () {
    Route::get(''                  , 'RegionController@index');
    Route::post('add-branch'       , 'RegionController@addBranchToRegions');
    Route::post('remove-branch'    , 'RegionController@removeBranchFromRegions');
});


//countries routes
Route::group([
    'prefix'    => 'countries',
], function () {
    Route::get('{country}'         , 'CountryController@find');
});


//locations routes
Route::group([
    'prefix'    => 'locations',
], function () {
    Route::get('find'             , 'LocationController@find');
});
