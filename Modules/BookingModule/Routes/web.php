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
    'prefix'    => 'vendor'
], function () {
    Route::get('bookings/transactions/{vendorId}'                , 'Admin\Vendor\BookingPaymentTransactionController@export')->name('vendor.transactions.export');
});


Route::group([
    'prefix'    => 'admin'
], function () {
    Route::get('bookings/transactions'                           , 'Admin\BookingPaymentTransactionController@export')->name('admin.transactions.export');
});
