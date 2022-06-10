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
    Route::post(''                      , 'RoleController@store');
    Route::put('{role}'                 , 'RoleController@update');
    Route::delete('{role}'              , 'RoleController@destroy');
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
    'namespace'  => 'Admin'
], function () {
    Route::get(''                       , 'AdminController@index');
    Route::post(''                      , 'AdminController@store');
    Route::put('{admin}'                , 'AdminController@update');
    Route::put('{admin}/password'       , 'AdminController@updatePassword');
    Route::delete('{admin}'             , 'AdminController@destroy');
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
    'namespace'  => 'Admin'
], function () {
    Route::post('login'                 , 'AuthAdminController@login');
});


//admin profile
Route::group([
    'prefix'     => 'profile',
    'middleware' => 'auth:admin_api',
    'namespace'  => 'Admin'
], function () {
    Route::get(''                       , 'AdminProfileController@getProfile');
    Route::put(''                       , 'AdminProfileController@updateProfile');
});


//vendor profile
Route::group([
    'prefix'     => 'vendor/profile',
    'middleware' => 'auth:vendor_api',
    'namespace'  => 'Admin'
], function () {
    Route::get(''                       , 'VendorProfileController@getProfile');
    Route::put(''                       , 'VendorProfileController@updateProfile');
    Route::put('info'                   , 'VendorProfileController@updateInfo');
});


//vendor auth
Route::group([
    'prefix'     => 'vendor/auth',
    'namespace'  => 'Admin'
], function () {
    Route::post('login'                 , 'AuthVendorController@login');
});
