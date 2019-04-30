<?php

namespace App\JsonAuth;

use Illuminate\Support\Facades\Route;

class JsonAuth
{
    /**
     * Register the typical authentication routes for an application using the JsonAuth.
     *
     * @param  array  $options
     * @return void
     */
    public static function routes(array $options = [])
    {
        //Current list of authentication routes.
        Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($options) {

            // Registration Routes...
            if ($options['register'] ?? true) {
                Route::post('register', 'RegisterController@register')->name('register');
                Route::post('register/validate', 'RegisterController@validateFields')->name('register.validate');
            }

            // Authentication Routes...;
            Route::post('login', 'LoginController@login')->name('login');

            Route::group(['middleware' => ['api']], function () {
                Route::post('refresh', 'LoginController@refresh');
                Route::get('me', 'LoginController@me');
            });

            Route::post('logout', 'LoginController@logout')->name('logout');

            // Password Reset Routes...
            if ($options['reset'] ?? true) {
                self::resetPassword();
            }

            // Email Verification Routes...
            if ($options['verify'] ?? false) {
                self::emailVerification();
            }
        });
    }

    /**
     * Register the typical reset password routes for an application.
     *
     * @return void
     */
    public static function resetPassword()
    {
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    }

    /**
     * Register the typical email verification routes for an application.
     *
     * @return void
     */
    public static function emailVerification()
    {
        Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
    }
}
