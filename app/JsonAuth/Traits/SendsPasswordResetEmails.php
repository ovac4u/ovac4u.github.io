<?php

namespace App\JsonAuth\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait SendsPasswordResetEmails
{
    use ExtendSendsPasswordResetEmails;

    /**
     * Send reset email
     *
     * Send a secret token to a user's email address to reset the user's password.
     *
     * @bodyParam email string required
     * The existing user's email address. Example: user@gmail.com
     *
     * @responseFile responses/v1/auth.password.email.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        return $this->parentSendResetLinkEmail($request);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return responder()->success(["message" => trans($response)]);
        }

        return $this->parentSendResetLinkResponse($request, $response);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if (request()->ajax() || request()->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return $this->parentSendResetLinkFailedResponse($request, $response);
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        if (request()->ajax() || request()->wantsJson()) {
            return [];
        }

        return $this->parentShowLinkRequestForm();
    }
}
