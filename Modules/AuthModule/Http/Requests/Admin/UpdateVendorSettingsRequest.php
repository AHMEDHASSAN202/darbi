<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|array',
            'name.ar'   => 'required|max:100',
            'name.en'   => 'required|max:100',
            'email'     => ['required', 'email'],
            'phone'     => 'required|numeric|digits_between:8,11',
            'image'     => 'sometimes|image|max:5120', //5m
            'country'   => ['required', new MongoIdRule],
            'settings'  => 'nullable|sometimes|array'
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
