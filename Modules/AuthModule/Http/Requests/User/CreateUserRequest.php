<?php

namespace Modules\AuthModule\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|max:100',
            'email'     => ['required', 'email', Rule::unique('vendors')],
            'password'  => ['required', 'max:100', Password::min(8)->letters()],
            'phone'     => ['required', 'numeric', 'digits_between:8,15', Rule::unique('vendors')],
            'image'     => 'nullable|image|max:5120', //5m
            'country'   => 'required|string|size:2',
            'city'      => 'required|string|size:2'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
