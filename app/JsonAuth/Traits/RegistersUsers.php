<?php

namespace App\JsonAuth\Traits;

use App\UserPhone;
use Illuminate\Http\Request;

trait RegistersUsers
{
    use ExtendedRegistersUsers;
    use RespondWithToken;

    /**
     * Register
     *
     * Creates a new user.
     *
     * @bodyParam first_name string required
     * The first name of the user. Example: Victor
     *
     * @bodyParam last_name string required
     * The last name of the user. Example: Ariama
     *
     * @bodyParam email string required
     * A valid and unique email address. Example: user@gmail.com
     *
     * @bodyParam country string required
     * A valid ISO 3166-1 alpha-2 country code. Example: gh
     *
     * @bodyParam phone string required
     * A valid phone number for the given country. Example: +233553577261
     *
     * @bodyParam username string
     * A valid and unique aplha_dash string. Example: ovac4u
     *
     * @bodyParam dob string
     * A valid date string for the user's date of birth. Example: 01/10/2001
     *
     * @bodyParam password string required
     * The password to use for this account. Example: google123
     *
     * @bodyParam password_confirmation string required
     * The password confirmation. Example: google123
     *
     * @bodyParam verify_phone boolean
     * When set to true, a verification code will be sent to the phone after the account is created. Example: true
     *
     * @responseFile responses/v1/auth.register.json
     */
    public function register(Request $request)
    {
        return $this->parentRegister($request);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    public function registered(Request $request, $user)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return $this->respondWithToken($this->guard()->tokenById($user->id))

            //A verification code will be sent to the user's phone number if the system has
            //been configured to start the verificaton procss when the user registers.
                ->meta((bool) $request->input('verify_phone')
                    ? ['message' => UserPhone::requestPhoneVerification($user, $request->only(['phone']))]
                    : []);
        }

        return $this->parentRegistered($request, $user);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (request()->ajax() || request()->wantsJson()) {
            return [];
        }

        return $this->parentShowRegistrationForm();
    }
}
