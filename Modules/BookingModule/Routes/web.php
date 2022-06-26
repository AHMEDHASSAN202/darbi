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


//vendor transactions
Route::group([
    'prefix'    => 'transactions'
], function () {
    Route::get('{vendorId}'                  , 'Admin\Vendor\BookingPaymentTransactionController@export')->name('vendor.transactions');
});
//62b26a36d1a2b901470d15fe
