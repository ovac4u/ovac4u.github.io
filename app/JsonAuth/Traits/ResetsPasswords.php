<?php

namespace App\JsonAuth\Traits;

use Illuminate\Http\Request;

trait ResetsPasswords
{
    use ExtendResetsPasswords;

    /**
     * Reset password
     *
     * Reset the given user's password.
     *
     * @bodyParam email string required
     * A valid and unique email address. Example: user@gmail.com
     *
     * @bodyParam token string required
     * The secret token that was sent to the user's email. Example: 32c224ec96b1aca6d3e3b2985b72e93ca019497467256c8b7c76131ece7467fc
     *
     * @bodyParam password string required
     * The password to use for this account. Example: google123
     *
     * @bodyParam password_confirmation string required
     * The password confirmation. Example: google123
     *
     * @responseFile responses/v1/auth.password.reset.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        return $this->parentReset($request);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return responder()->success(["message" => trans($response)]);
        }

        return $this->parentSendResetResponse($response);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return responder()->error(400, trans($response))->respond(424);
        }

        return $this->parentSendResetResponse($request, $response);
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return [];
        }

        return $this->parentShowResetForm();
    }
}
