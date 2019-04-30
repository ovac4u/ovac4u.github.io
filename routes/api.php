<?php

use App\JsonAuth\JsonAuth;

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

//Define the API version using the prefix.
Route::group(['prefix' => 'v1'], function () {

    /**
     * User's uthentication routes.
     */
    JsonAuth::routes(['verify' => true]);

    /**
     * The application's routes for authenticated users.
     */
    Route::group(['middleware' => 'auth', 'namespace' => 'UserApp'], function () {

        /**
         * Routes for handling user's phone number and verification.
         */
        Route::apiResource('phones', 'UserPhoneController')->except(['update', 'store']);

        Route::apiResource('phones', 'UserPhoneController')->only(['store'])->middleware('throttle:5,1');

        Route::put('phones/set-default/{phone}', 'UserPhoneController@setDefault')->name('phones.setDefault');

        Route::put('phones', 'UserPhoneController@verify')->name('phones.verify')->middleware('throttle:10,1');

        /**
         * Routes for handling the user's account settings
         */
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {

            Route::patch('password', 'SettingController@changePassword')->name('change.password');

            Route::patch('profile', 'SettingController@updateProfile')->name('update.profile');
        });
    });
});
