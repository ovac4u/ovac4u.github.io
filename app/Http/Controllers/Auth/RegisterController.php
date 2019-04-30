<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\JsonAuth\Traits\RegistersUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Authentication
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|alpha|min:3|max:32',
            'last_name' => 'required|min:3|max:32',
            'password' => 'required|min:6|confirmed',
            'dob' => 'required|date',
        ] + $this->reusableRules());
    }

    /**
     * Rule fragment used for validating the user's username.
     *
     * @return array
     */
    protected function reusableRules($required = 'required')
    {
        return [
            'username' => 'nullable|string|alpha_dash|min:3|max:32|unique:users',
            'email' => $required . '|email|unique:users',

            //Validate the phone with the given country.
            'phone' => [
                'bail',
                $required,
                'phone:country',
                'unique:user_phones',
                function ($attribute, $value, $fail) {
                    if (!validatePhone($value)) {
                        return $fail(trans('validation.phone_intl'));
                    }
                },
            ],
            'country' => 'required_with:phone',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create(
            array_merge(
                array('password' => bcrypt(
                    $data['password']///
                )), //////////////////
                array_only($data, [
                    'first_name',
                    'last_name',
                    'username',
                    'country',
                    'phone',
                    'email',
                    'dob',
                ])
            )
        );
    }

    /**
     * Validate registration fields
     *
     * This route can be used to check some fields on the fly during registration especially for unique fields.
     *
     * @bodyParam phone string
     * A valid phone number for the given country. Example: 0553577261
     *
     * @bodyParam country string
     * A valid ISO 3166-1 alpha-2 country code. `required when phone is present` Example: gh
     *
     * @bodyParam email string
     * A valid and unique email address. Example: user@gmail.com
     *
     * @response
     *  {
     *     "status": 200,
     *     "success": true,
     *     "data": null
     *  }
     *
     * @param  Request $request
     * @return Response
     */
    public function validateFields(Request $request)
    {
        $request->validate($this->reusableRules('nullable'));

        return responder()->success();
    }
}
