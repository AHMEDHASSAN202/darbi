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
Route::group(['prefix' => 'roles', 'middleware' => 'auth:admin_api'], function () {
    Route::get(''           , 'RoleController@index');
    Route::post(''          , 'RoleController@store');
    Route::put('{role}'     , 'RoleController@update');
    Route::delete('{role}'  , 'RoleController@destroy');
});


