<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */


//file manager
Route::group([
    'prefix'     => 'admin/file-manager',
    'middleware' => ['auth:admin_api', 'permission:manage-file-manager'],
    'namespace'  => 'FileManager'
], function () {
    Route::get(''                       , 'FileManagerController@index');
    Route::post('upload'                , 'FileManagerController@uploadFile');
    Route::post('upload-link'           , 'FileManagerController@uploadFromLink');
    Route::post('cropped'               , 'FileManagerController@croppedImage');
    Route::post('delete'                , 'FileManagerController@delete');
    Route::post('rename'                , 'FileManagerController@rename');
    Route::post('move'                  , 'FileManagerController@move');
    Route::post('create-directory'      , 'FileManagerController@createDirectory');
});
