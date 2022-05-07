<?php

namespace Modules\ProfileModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'phone'     => ['required', 'numeric', 'digits_between:8,15', Rule::unique('vendors')->ignore($me->phone, 'phone')],
            'image'     => 'sometimes|image|size:5120', //5m
            'country'   => 'required|string|max:100',
            'city'      => 'required|string|max:100'
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
