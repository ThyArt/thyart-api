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
    Route::post('', 'UserController@store') ;
    Route::post('/member', 'UserController@storeMember')->middleware('permission:store member');
    Route::delete('/member/{user}', 'UserController@destroyMember')->middleware('permission:delete member');
    Route::get('', 'UserController@index');
    Route::get('/self', 'UserController@showByToken');
    Route::get('/self/permissions', 'UserController@getOwnPermissions');
    Route::get('/{user}/permissions', 'UserController@getUserPermissions');
    Route::post('/role/{user}', 'UserController@updateRole')->middleware('permission:update role');
    Route::post('/permission/{user}/{permission}', 'UserController@updatePermission')->middleware('permission:update role');
    Route::get('/{user}', 'UserController@show');
    Route::patch('', 'UserController@update');
    Route::delete('', 'UserController@destroy');
});

Route::group(["namespace" => 'Api', 'prefix' => 'gallery', 'middleware' => 'auth:api'], function () {
    Route::get('/', 'GalleryController@show');
    Route::patch('/', 'GalleryController@update');
    Route::delete('/', 'GalleryController@destroy');
});

Route::group(["namespace" => 'Api', 'prefix' => 'artist', 'middleware' => 'auth:api'], function () {
    Route::post('', 'ArtistController@store')->middleware('permission:store artist');
    Route::get('', 'ArtistController@index')->middleware('permission:get artist');
    Route::get('/{artist}', 'ArtistController@show')->middleware('permission:get artist');
    Route::patch('/{artist}', 'ArtistController@update')->middleware('permission:update artist');
    Route::delete('/{artist}', 'ArtistController@destroy')->middleware('permission:destroy artist');
});

Route::group(["namespace" => 'Api', 'prefix' => 'customer', 'middleware' => 'auth:api'], function () {
    Route::post('', 'CustomerController@store')->middleware('permission:store customer');
    Route::get('', 'CustomerController@index')->middleware('permission:get customer');
    Route::get('/{customer}', 'CustomerController@show')->middleware('permission:get customer');
    Route::patch('/{customer}', 'CustomerController@update')->middleware('permission:update customer');
    Route::delete('/{customer}', 'CustomerController@destroy')->middleware('permission:destroy customer');
});

Route::group(["namespace" => 'Api', 'prefix' => 'exhibition', 'middleware' => 'auth:api'], function () {
    Route::post('', 'ExhibitionController@store')->middleware('permission:store exhibition');
    Route::get('', 'ExhibitionController@index')->middleware('permission:get exhibition');
    Route::get('/{exhibition}', 'ExhibitionController@show')->middleware('permission:get exhibition');
    Route::patch('/{exhibition}', 'ExhibitionController@update')->middleware('permission:update exhibition');
    Route::delete('/{exhibition}', 'ExhibitionController@destroy')->middleware('permission:destroy exhibition');
});

Route::group(["namespace" => 'Api', 'prefix' => 'newsletter', 'middleware' => 'auth:api'], function () {
    Route::post('', 'NewsletterController@store')->middleware('permission:store newsletter');
    Route::get('', 'NewsletterController@index')->middleware('permission:get newsletter');
    Route::get('/{newsletter}', 'NewsletterController@show')->middleware('permission:get newsletter');
    Route::patch('/{newsletter}', 'NewsletterController@update')->middleware('permission:update newsletter');
    Route::delete('/{newsletter}', 'NewsletterController@destroy')->middleware('permission:destroy newsletter');
    Route::post('/{newsletter}', 'NewsletterController@send')->middleware('permission:send newsletter');
    Route::get('/preview/{newsletter}', 'NewsletterController@preview')->middleware('permission:get newsletter');
});

Route::group(["namespace" => 'Api', 'prefix' => 'order', 'middleware' => 'auth:api'], function () {
    Route::post('', 'OrderController@store');
    Route::get('', 'OrderController@index');
    Route::get('/{order}', 'OrderController@show');
    Route::delete('/{order}', 'OrderController@destroy');
});

Route::group(["namespace" => 'Api', 'prefix' => 'artwork', 'middleware' => 'auth:api'], function () {
    Route::post('', 'ArtworkController@store')->middleware('permission:store artwork');
    Route::get('', 'ArtworkController@index')->middleware('permission:get artwork');
    Route::get('/{artwork}', 'ArtworkController@show')->middleware('permission:get artwork');
    Route::patch('/{artwork}', 'ArtworkController@update')->middleware('permission:update artwork');
    Route::delete('/{artwork}', 'ArtworkController@destroy')->middleware('permission:destroy artwork');

    Route::post('/{artwork}/image', 'ArtworkController@storeImage')->middleware('permission:store artwork image');
    Route::delete('/{artwork}/image/{media}', 'ArtworkController@destroyImage')->middleware('permission:destroy artwork image');
});


Route::group(["namespace" => 'Auth', 'prefix' => 'password'], function () {
    Route::post('create', 'PasswordResetController@create');
});

Route::group(["namespace" => 'Api', 'prefix' => 'stat', 'middleware' => 'auth:api'], function () {
    Route::get('', 'StatController@process');
});
