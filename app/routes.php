<?php

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

Route::get('/', function()
{
	return View::make('hello');
});

Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
Route::resource('service-types', 'ServiceTypeController', ['except' => ['create', 'edit']]);
Route::resource('services', 'ServiceController', ['except' => ['create', 'edit']]);
Route::resource('services.reviews', 'ReviewController', ['except' => ['create', 'edit']]);

Route::get('requests/sent-requests', 'RequestController@sentRequests');
Route::get('requests/recieved-requests', 'RequestController@recievedRequests');
Route::resource('requests', 'RequestController', ['only' => ['index', 'store', 'update', 'destroy']]);
