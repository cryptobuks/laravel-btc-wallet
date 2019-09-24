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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['reset' => false]);


Route::get('/home', 'HomeController@index')->name('home');
Route::post('/wallet/generate/address', 'WalletController@generate_address');
Route::post('/wallet/generate/new', 'WalletController@generate_wallet');
Route::post('/wallet/send', 'WalletController@send');

Route::get('/wallet/transactions/{identifier}', 'WalletController@transactions');
