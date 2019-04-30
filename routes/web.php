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

Route::view('/', 'welcome')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'login-with', 'namespace' => 'Auth'], function () {

    Route::get('{provider}', 'SocialAccountController@redirectToProvider');

    Route::get('{provider}/callback', 'SocialAccountController@handleProviderCallback');
});

/**
 * User web app routes
 * Hand routing over to the react app if no routes has been matched.
 */
Route::view('password/reset', 'react-app')->name('password.reset');
Route::view('{slug}', 'react-app')->where('slug', '(?!api|nova-api)([A-z\d-\/_.]+)?');
