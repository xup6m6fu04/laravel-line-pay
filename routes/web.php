<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/line-pay/form', 'LinePayController@form')->name('form');

Route::any('/line-pay/confirm', 'LinePayController@confirm');
Route::any('/line-pay/cancel', 'LinePayController@cancel');
Route::any('/line-pay/refund', 'LinePayController@refund');
Route::any('line-pay/get-payment-info', 'LinePayController@getPaymentInfo');
