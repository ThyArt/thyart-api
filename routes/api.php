<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->group(function () {
    Route::post('', 'Api\UserController@store');
    Route::get('', 'Api\UserController@index');
    Route::get('/{user}', 'Api\UserController@show');
    Route::patch('', 'Api\UserController@update');
    Route::delete('', 'Api\UserController@destroy');
});

Route::middleware('auth:api')->prefix('artist')->group(function () {
    Route::post('', 'Api\ArtistController@store');
    Route::get('', 'Api\ArtistController@index');
    Route::get('/{artist}', 'Api\ArtistController@show');
    Route::patch('/{artist}', 'Api\ArtistController@update');
    Route::delete('/{artist}', 'Api\ArtistController@destroy');
});
Route::post('customer', 'Api\CustomerController@store');
Route::get('customer', 'Api\CustomerController@index');
Route::get('customer/{customer}', 'Api\CustomerController@show');
Route::patch('customer', 'Api\CustomerController@update');
Route::delete('customer', 'Api\CustomerController@destroy');