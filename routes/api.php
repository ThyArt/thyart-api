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

Route::get('/ping', 'Api\PingController@ping');

Route::group(["namespace" => 'Api', 'prefix' => 'user'], function () {
    Route::post('', 'UserController@store');
    Route::get('', 'UserController@index');
    Route::get('/self', 'UserController@showByToken');
    Route::get('/{user}', 'UserController@show');
    Route::patch('', 'UserController@update');
    Route::delete('', 'UserController@destroy');
});

Route::group(["namespace" => 'Api', 'prefix' => 'gallery', 'middleware' => 'auth:api'], function () {
    Route::post('', 'GalleryController@store');
    Route::get('', 'GalleryController@index');
    Route::get('/{gallery}', 'GalleryController@show');
    Route::patch('/{gallery}', 'GalleryController@update');
    Route::delete('/{gallery}', 'GalleryController@destroy');
});

Route::group(["namespace" => 'Api', 'prefix' => 'artist', 'middleware' => 'auth:api'], function () {
    Route::post('', 'ArtistController@store');
    Route::get('', 'ArtistController@index');
    Route::get('/{artist}', 'ArtistController@show');
    Route::patch('/{artist}', 'ArtistController@update');
    Route::delete('/{artist}', 'ArtistController@destroy');
});

Route::group(["namespace" => 'Api', 'prefix' => 'customer', 'middleware' => 'auth:api'], function () {
    Route::post('', 'CustomerController@store');
    Route::get('', 'CustomerController@index');
    Route::get('/{customer}', 'CustomerController@show');
    Route::patch('/{customer}', 'CustomerController@update');
    Route::delete('/{customer}', 'CustomerController@destroy');
});

Route::group(["namespace" => 'Auth', 'prefix' => 'password'], function () {
    Route::post('create', 'PasswordResetController@create');
});
