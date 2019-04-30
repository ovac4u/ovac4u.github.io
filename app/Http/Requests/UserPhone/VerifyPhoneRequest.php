<?php

namespace App\Http\Requests\UserPhone;

class VerifyPhoneRequest extends VerificationCodeRequest
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
        return parent::rules() + ['code' => 'required|numeric'];
    }
}
