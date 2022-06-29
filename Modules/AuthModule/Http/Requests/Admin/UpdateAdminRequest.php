<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required', 'max:100', new AlphaNumSpacesRule()],
            'email'         => ['required', 'email', Rule::unique('admins')->ignore($this->route('admin'), '_id')],
            'role_id'       => ['required', Rule::exists('roles', '_id')->where('guard', $this->request->get('type') . '_api')],
            'type'          => 'required|in:admin,vendor',
            'vendor_id'     => 'required_if:type,vendor',
            'password'      => ['sometimes', 'nullable', 'max:100', 'confirmed', Password::min(8)->letters()],
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
