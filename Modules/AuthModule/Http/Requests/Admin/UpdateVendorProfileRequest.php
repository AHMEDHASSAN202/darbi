<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateVendorProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $me = auth('vendor_api')->user();

        return [
            'name'      => 'required|max:100',
            'email'     => ['required', 'email', Rule::unique('admins')->ignore($me->id, '_id')],
            'password'  => ['sometimes', 'nullable', 'max:100', 'confirmed', Password::min(8)->letters()],
            'image'     => 'sometimes|image|max:5120' //5m
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
