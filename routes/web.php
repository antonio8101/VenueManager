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



/** AUTH */
Route::get( '/', 'MainController@index' );
Route::get( '/login', 'MainController@login' )->name( 'login' );
Route::get( '/logout', 'MainController@logout' )->name( 'logout' );

/** WEBAPP */
/** ROUTE - GRANTED TO HTML/JS APPLICATION */
Route::any('/app', 'MainController@app')->where(['all','.*']);
Route::any('/app/{all}', 'MainController@app')->where(['all','.*']);
Route::any('/app/{all}/{all_all}', 'MainController@app')->where(['all_all','.*']);
Route::any('/app/{all}/{all_all}/{all_all_all}', 'MainController@app')->where(['all_all_all','.*']);

/** API */
Route::any( '/api/login', 'AuthController@login' )->name( 'loginAttempt' );

/** API USER */
Route::get( '/api/user/get/{id}', 'Api\UserController@getOneUserQuery' )->name('GetOneUserQuery');
Route::any( '/api/user/search', 'Api\UserController@getUsersQuery' )->name('UsersQuery');
Route::any( '/api/user/create', 'Api\UserController@createUserCommand' )->name('CreateUserCommand');
Route::any( '/api/user/edit', 'Api\UserController@editUserCommand' )->name('EditUserCommand');
Route::any( '/api/user/delete', 'Api\UserController@deleteUserCommand' )->name('DeleteUserCommand');

/** API VENUE */
Route::get( '/api/venue/get/{id}', 'Api\VenueController@getOneVenueQuery' )->name('GetOneVenueQuery');
Route::any( '/api/venue/search', 'Api\VenueController@getVenuesQuery' )->name('VenuesQuery');
Route::any( '/api/venue/create', 'Api\VenueController@createVenueCommand' )->name('CreateVenueCommand');
Route::any( '/api/venue/edit', 'Api\VenueController@editVenueCommand' )->name('EditVenueCommand');
Route::any( '/api/venue/delete', 'Api\VenueController@deleteVenueCommand' )->name('DeleteVenueCommand');

/** API USER VENUE */
Route::any( '/api/uservenue/create', 'Api\UserVenueController@createUserVenueRelationCommand' )->name('CreateUserVenueCommand');
Route::any( '/api/uservenue/delete', 'Api\UserVenueController@deleteUserVenueRelationCommand' )->name('DeleteUserVenueCommand');