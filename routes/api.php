<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user', 'Api\UserController@store');

Route::get('user', 'Api\UserController@index');

Route::get('user/{user}', 'Api\UserController@show');

Route::patch('user', 'Api\UserController@update');

Route::delete('user', 'Api\UserController@destroy');
