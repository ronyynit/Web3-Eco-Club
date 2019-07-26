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
Route::get('/', 'LoansController@welcome')->name('home');


Route::post('loans', 'LoansController@store')->name('loans');

Route::get('/admin', 'LoansController@index')->name('admin');

Route::get('/calc', 'LoansController@show')->name('calc');
