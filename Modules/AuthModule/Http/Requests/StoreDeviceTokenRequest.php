<?php

namespace Modules\AuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_uuid'      => 'required',
            'device_os'       => 'required|in:android,ios,web',
            'lat'             => 'sometimes|nullable|numeric',
            'lng'             => 'sometimes|nullable|numeric',
            'region_id'       => 'sometimes|nullable|exists:regions,_id'
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
