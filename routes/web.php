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

// USER
Route::get( '/api/user/get/{id}', 'Api\UserController@getOneUserQuery' )->name('GetOneUserQuery');
Route::any( '/api/user/list', 'Api\UserController@getUsersQuery' )->name('UsersQuery');
Route::any( '/api/user/create', 'Api\UserController@createUserCommand' )->name('CreateUserCommand');
Route::any( '/api/user/edit', 'Api\UserController@editUserCommand' )->name('EditUserCommand');