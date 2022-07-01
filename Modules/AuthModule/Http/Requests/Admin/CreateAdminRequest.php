<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required', 'max:100'],
            'name'          => ['required', 'max:100', new AlphaNumSpacesRule()],
            'email'         => 'required|email|unique:admins',
            'role_id'       => 'required|exists:roles,_id',
            'password'      => ['required', Password::min(8)->letters(), 'confirmed'],
            'type'          => 'required|in:admin,vendor',
            'vendor_id'     => 'required_if:type,vendor|exists:vendors,_id',
            'image'         => 'sometimes|image|max:5120' //5m
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
