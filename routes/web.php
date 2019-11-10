<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api'], function () {
	
	Route::get('/', function () {
		return "Medic API v1";
	});
	
	// CRUD User
	Route::get('users', 'UserController@index');
	Route::get('users/{user}', 'UserController@show');
	Route::post('users', 'UserController@store');
	Route::put('users/{user}', 'UserController@update');
	Route::delete('users/{user}', 'UserController@delete');
	
	// Login
	Route::post('login', 'AuthenticationController@login');
	
});
