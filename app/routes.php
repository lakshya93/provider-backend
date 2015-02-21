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

Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
Route::resource('service-types', 'ServiceTypeController', ['except' => ['create', 'edit']]);
Route::resource('services', 'ServiceController', ['except' => ['create', 'edit']]);
Route::resource('services.reviews', 'ReviewController', ['only' => ['index', 'store', 'destroy']]);
Route::resource('services.images', 'ImageController', ['except' => ['create', 'edit', 'show']]);

Route::get('requests/sent-requests', 'RequestController@sentRequests');
Route::get('requests/received-requests', 'RequestController@receivedRequests');
Route::resource('requests', 'RequestController', ['only' => ['index', 'store', 'update', 'destroy']]);
