<?php

namespace App\JsonAuth\Traits;

use Illuminate\Http\Request;

trait AuthenticatesUsers
{
    use ExtendedAuthenticatesUsers;

    /**
     * Login account
     *
     * A login request will return a valid JWT token along with the user's object.
     * The token must be added as a HTTP header to all API calls that requires
     * authentication in the HTTP `Authorization` header like so:
     *
     * `Authorization: Bearer <your token goes here>`
     *
     * @bodyParam login string required
     * The user's registered email address or valid international phone number or username. Example: +233553577261. Example: user@gmail.com Example: ovac4u
     *
     * @bodyParam password string required
     * The user's password. Example: google123
     *
     * @responseFile responses/v1/auth.login.json
     */
    public function login(Request $request)
    {
        return $this->parentLogin($request);
    }

    /**
     * Logout account
     *
     * Invalidate the current authentication token and logout the user.
     *
     * @authenticated
     * @responseFile responses/v1/auth.logout.json
     */
    public function logout(Request $request)
    {
        return $this->parentLogout($request);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticated(Request $request, $user)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return $this->respondWithToken($this->guard()->tokenById($user->id));
        }

        return $this->parentAuthenticated($request, $user);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt($this->credentials($request));
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (request()->ajax() || request()->wantsJson()) {
            return [];
        }

        return $this->parentShowLoginForm();
    }
}
