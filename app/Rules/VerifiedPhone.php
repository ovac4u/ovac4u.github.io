<?php

namespace App\Rules;

use App\UserPhone;
use Illuminate\Contracts\Validation\Rule;

class VerifiedPhone implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'validation.verified_phone';
    }

    /**
     * Validates a google 2factor Auth.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  array  $parameters
     * @param  object $validator
     * @return bool
     */
    public function validate($attribute, $value, array $parameters, $validator)
    {
        $parameters = $parameters + [null, null];

        try {
            $phone = validatePhone($value, $parameters[1]);
        } catch (\Exception $e) {
            return false;
        }

        if (UserPhone::where('phone', $phone)->where('user_id', $parameters[0])->get()) {
            return true;
        }
    }
}
