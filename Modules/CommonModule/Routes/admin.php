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



Route::group([
    'prefix'        => 'countries',
    'middleware'    => 'auth:admin_api'
], function () {
    Route::get(''                        , 'CountryController@index');
    Route::put('{country}/toggle-active' , 'CountryController@toggleActive');
});


Route::group([
    'prefix'        => 'cities',
    'middleware'    => 'auth:admin_api'
], function () {
    Route::get(''                        , 'CityController@index');
    Route::put('{city}/toggle-active'    , 'CityController@toggleActive');
});


Route::group([
    'prefix'        => 'settings',
    'middleware'    => 'auth:admin_api'
], function () {
    Route::get(''                        , 'SettingController@index');
    Route::post(''                       , 'SettingController@update');
    Route::post('clear-cache'            , 'SettingController@clearSettingCache');
    Route::delete('walk-through/{index}' , 'SettingController@removeWalkThroughImage');
});
