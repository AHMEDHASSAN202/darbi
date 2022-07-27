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


//admin players
Route::group([
    'prefix'     => 'players',
], function () {
    Route::get(''                       , 'UserDeviceTokenController@index');
});


//user routes
Route::group([
    'prefix'     => 'users',
], function () {
    Route::get('ids'                    , 'UserController@findAllIds');
});


//admin routes
Route::group([
    'prefix'     => 'admins',
], function () {
    Route::get('ids'                    , 'AdminController@findAllIds');
    Route::get('{vendor}/token'         , 'AdminController@getVendorAdminToken');
});


//admin routes
Route::group([
    'prefix'     => 'roles',
], function () {
    Route::get('vendor-role/find'       , 'RoleController@findVendorRole');
});
