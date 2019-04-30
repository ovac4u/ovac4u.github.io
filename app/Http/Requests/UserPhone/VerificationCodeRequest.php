<?php

namespace App\Http\Requests\UserPhone;

use Illuminate\Foundation\Http\FormRequest;

class VerificationCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //Validate the phone with the given country.
            'phone' => [
                'bail',
                'required',
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
}
