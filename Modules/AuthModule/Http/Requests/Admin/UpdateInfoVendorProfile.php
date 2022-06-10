<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use function auth;

class UpdateInfoVendorProfile extends FormRequest
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
            'phone'     => ['required', 'numeric', 'digits_between:8,15', Rule::unique('vendors')->ignore($me->id, '_id')],
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
