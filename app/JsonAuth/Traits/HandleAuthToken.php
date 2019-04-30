<?php

namespace App\JsonAuth\Traits;

use Illuminate\Http\Request;

trait HandleAuthToken
{
    use RespondWithToken;

    /**
     * Get the authenticated User.
     *
     * Retrieve the authenticated user from using the bearer token.
     *
     * @authenticated
     * @responseFile responses/v1/auth.me.json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return responder()->success($this->guard()->user());
    }

    /**
     * Refresh token.
     *
     * Refresh the api token of the currently authenticated user.
     *
     * @authenticated
     * @responseFile responses/v1/auth.refresh.json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function loggedOut(Request $request)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return responder()->success(['message' => 'Successfully logged out']);
        }

        return parent::loggedOut($request);
    }
}
