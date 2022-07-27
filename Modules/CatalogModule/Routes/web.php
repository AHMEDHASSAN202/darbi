<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get(''               , 'HomeController@index');
Route::get('about'          , 'HomeController@about');
Route::get('contact'        , 'HomeController@contact');
Route::get('policy'         , 'HomeController@policy');


Route::get('/lang/{lang}', function ($lang) {
    __set_lang($lang);
    return redirect()->back();
})->whereIn('lang', ['ar', 'en']);
