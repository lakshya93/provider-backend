<?php
header('Access-Control-Allow-Origin: *');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::post('login', 'UserController@login');//->before('guest');
Route::get('logout', 'UserController@logout');//->before('auth');



Route::post('users/{id}/change-password', 'UserController@changePassword');//->before('auth');
Route::post('users/{id}/change-photo', 'UserController@changePhoto');//->before('auth');

// Route::group(['before' => 'auth', function() {
	Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
	Route::resource('service-types', 'ServiceTypeController', ['except' => ['create', 'edit']]);
	Route::resource('services', 'ServiceController', ['except' => ['create', 'edit']]);
	Route::resource('services.reviews', 'ReviewController', ['only' => ['index', 'store', 'update', 'destroy']]);
	Route::resource('services.images', 'ImageController', ['except' => ['create', 'edit', 'show']]);
	Route::resource('requests', 'RequestController');
// });
