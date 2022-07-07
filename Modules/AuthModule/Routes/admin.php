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


//admin routes roles
Route::group([
    'prefix'     => 'roles',
    'middleware' => ['auth:admin_api', 'permission:manage-roles'],
    'namespace'  => 'Role'
], function () {
    Route::get(''                       , 'RoleController@index');
    Route::get('{role}'                 , 'RoleController@show');
    Route::post(''                      , 'RoleController@store');
    Route::put('{role}'                 , 'RoleController@update');
    Route::delete('{role}'              , 'RoleController@destroy');
    Route::get('vendor-role/find'       , 'RoleController@findVendorRole');
});


//permissions list
Route::group([
    'prefix'     => 'permissions',
    'middleware' => ['auth:admin_api', 'permission:manage-roles'],
    'namespace'  => 'Role'
], function () {
    Route::get(''                       , 'PermissionController@index');
});


//admin routes admins
Route::group([
    'prefix'     => 'admins',
    'middleware' => ['auth:admin_api', 'permission:manage-admins'],
    'namespace'  => 'CURD'
], function () {
    Route::get(''                       , 'AdminController@index');
    Route::get('ids'                    , 'AdminController@findAllIds');
    Route::get('{admin}'                , 'AdminController@show');
    Route::post(''                      , 'AdminController@store');
    Route::put('{admin}'                , 'AdminController@update');
    Route::put('{admin}/password'       , 'AdminController@updatePassword');
    Route::delete('{admin}'             , 'AdminController@destroy');
    Route::get('{vendor}/token'         , 'AdminController@getVendorAdminToken');
});



//user routes
Route::group([
    'prefix'     => 'users',
    'middleware' => ['auth:admin_api', 'permission:manage-admins'],
    'namespace'  => 'CURD'
], function () {
    Route::get(''                       , 'UserController@index');
    Route::get('ids'                    , 'UserController@findAllIds');
    Route::get('{user}'                 , 'UserController@show');
    Route::put('{user}/toggle-active'   , 'UserController@toggleActive');
    Route::delete('{admin}'             , 'UserController@destroy');
});



//admin activities
Route::group([
    'prefix'     => 'activities',
    'middleware' => ['auth:admin_api', 'permission:manage-admins'],
], function () {
    Route::get('{admin}'                , 'ActivityController@show');
});


//admin auth
Route::group([
    'prefix'     => 'auth',
    'namespace'  => 'Auth'
], function () {
    Route::post('login'                 , 'AuthAdminController@login');
});


//admin profile
Route::group([
    'prefix'     => 'profile',
    'middleware' => 'auth:admin_api',
    'namespace'  => 'Profile'
], function () {
    Route::get(''                       , 'AdminProfileController@getProfile');
    Route::put(''                       , 'AdminProfileController@updateProfile');
});



//admin players
Route::group([
    'prefix'     => 'players',
    'middleware' => 'auth:admin_api',
], function () {
    Route::get(''                       , 'UserDeviceTokenController@index');
});
