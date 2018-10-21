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

Route::get( '/', 'MainController@index' );
Route::get( '/login', 'MainController@login' )->name( 'login' );
Route::get( '/logout', 'MainController@logout' )->name( 'logout' );
Route::any( '/api/login', 'AuthController@login' )->name( 'loginAttempt' );
Route::get( '/api/venue/get/{id}', 'Api\VenueController@getOneVenueQuery' );
Route::get( '/api/user/get/{id}', 'Api\UserController@getOneUserQuery' )->name('getOneUserQuery');
Route::any( '/api/user/list', 'Api\UserController@getUsersQuery' )->name('getUsersQuery');