<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
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
            'first_name' => 'sometimes|required|string|max:50',
            'last_name' => 'sometimes|required|string|max:50',
            'other_names' => 'nullable|string|max:50',

            'email' => 'sometimes|required|string|email|max:50|unique:users,email,' . auth()->id(),
            'username' => 'nullable|string|alpha_dash|min:3|max:32|unique:users,username,' . auth()->id(),
        ];
    }
}
