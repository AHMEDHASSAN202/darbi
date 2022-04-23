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

Route::group([
    'prefix'   => 'dashboard/file-manager',
    'middleware' => ['auth:admin_api', 'permission:manage-file-manager']
], function () {
    Route::get(''                       , 'FileManagerModuleController@index');
    Route::post('upload'                , 'FileManagerModuleController@uploadFile');
    Route::post('upload-link'           , 'FileManagerModuleController@uploadFromLink');
    Route::post('cropped'               , 'FileManagerModuleController@croppedImage');
    Route::post('delete'                , 'FileManagerModuleController@delete');
    Route::post('rename'                , 'FileManagerModuleController@rename');
    Route::post('move'                  , 'FileManagerModuleController@move');
    Route::post('create-directory'      , 'FileManagerModuleController@createDirectory');
});
