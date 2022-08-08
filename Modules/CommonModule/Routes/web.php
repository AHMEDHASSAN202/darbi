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


Route::get(''                          , 'Web\HomeController@index');
Route::get('mobile/about-us'           , 'Web\PageController@about');
Route::get('mobile/contact-us'         , 'Web\PageController@contact');
Route::get('mobile/privacy'            , 'Web\PageController@policy');


Route::get('/lang/{lang}', function ($lang) {
    setLanguage($lang);
    return redirect()->back();
})->whereIn('lang', ['ar', 'en']);
