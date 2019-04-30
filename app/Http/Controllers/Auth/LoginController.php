<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\JsonAuth\Traits\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @group Authentication
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * The name of the field to read the value of
     * the username, phone number or email from.
     *
     * @var string
     */
    protected $loginField = 'login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'refresh', 'me']);
        $this->middleware('session')->only(['login', 'logout']);
    }

    /**
     * Get the login username to be used by the controller.
     * This could be either the user's email or phone-number
     *
     * @return string
     */
    public function username()
    {
        if ($login = request()->input($this->loginField)) {
            //Automatically detect the user's login input type.
            $field = $this->getFieldType($login);

            if ($field === 'default_phone_id') {
                $phone = User::byDefaultPhone($login);

                $login = (string) (optional($phone)->id ?: $this->sendFailedLoginResponse(request()));
            }

            //Merge the field and it's value to the input.
            request()->merge([$field => $login]);

            //Give laravel the field to work with.
            return $field;
        }

        return $this->loginField;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->loginField => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login field type.
     * @param  string $login The login input data.
     * @return string        The detected field type.
     */
    protected function getFieldType($login)
    {
        switch ($login) {
            case filter_var($login, FILTER_VALIDATE_EMAIL):
                return 'email';

            case validatePhone($login):
                return 'default_phone_id';

            default:
                return 'username';
        }
    }
}
