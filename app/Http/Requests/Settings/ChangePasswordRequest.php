<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /**
     * The current password field.
     *
     * @var string
     */
    protected $currentPasswordField = 'current_password';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string|confirmed',
            $this->currentPasswordField => 'required',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        // checks user current authenticated user's password.
        $validator->after(function ($validator) {
            if (!Hash::check($this->input($this->currentPasswordField), $this->user()->password)) {
                $validator->errors()->add($this->currentPasswordField, __('validation.incorrect_password'));
            }
        });
    }
}
