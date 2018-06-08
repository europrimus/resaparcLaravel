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

Route::get('/', 'BilletController@index' );
Route::get('/deconexion', 'BilletController@deconexion' );
Route::post('/', 'BilletController@register' );
Route::get('/reservation', 'ReservationController@index' );
Route::get('/manege', 'ManegeController@index' );
