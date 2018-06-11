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
// reponse html
Route::get('/', 'BilletController@index' );
Route::get('/deconexion', 'BilletController@deconexion' );
Route::post('/', 'BilletController@register' );

Route::get('/reservation', 'ReservationController@index' );
Route::get('/reserver/{id}', 'ReservationController@store' )->where('id','[0-9]+');
Route::get('/reservation/{id}/annuler', 'ReservationController@destroy' )->where('id','[0-9]+');

Route::get('/manege', 'ManegeController@index' );

Route::get('/mobi', function(){return view('mobile');} );

// reponse Json
Route::prefix('/api')->group(function () {

  Route::any('/connexion', 'API@connexion' );
  Route::any('/deconexion', 'API@deconexion' );

  Route::any('/reservation', 'API@reservation' );
  Route::any('/reserver/{id}', 'API@reserver' )->where('idManege','[0-9]+');
  Route::any('/reservation/{id}/annuler', 'API@annuler' )->where('idResa','[0-9]+');

  Route::any('/manege', 'API@manege' );
});
