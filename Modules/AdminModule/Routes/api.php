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

//dashboard routes roles
Route::group(['prefix' => 'roles', 'middleware' => ['auth:admin_api', 'permission:manage-roles']], function () {
    Route::get(''                       , 'RoleController@index');
    Route::post(''                      , 'RoleController@store');
    Route::put('{role}'                 , 'RoleController@update');
    Route::delete('{role}'              , 'RoleController@destroy');
});

//permissions list
Route::group(['prefix' => 'permissions', 'middleware' => ['auth:admin_api', 'permission:manage-roles']], function () {
    Route::get(''                       , 'PermissionController@index');
});

//dashboard routes admins
Route::group(['prefix' => 'admins', 'middleware' => ['auth:admin_api', 'permission:manage-admins']], function () {
    Route::get(''                       , 'AdminController@index');
    Route::post(''                      , 'AdminController@store');
    Route::put('{admin}'                , 'AdminController@update');
    Route::put('{admin}/password'       , 'AdminController@updatePassword');
    Route::delete('{admin}'             , 'AdminController@destroy');
});


