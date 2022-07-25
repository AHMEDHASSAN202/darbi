<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\PhoneRule;
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
            'name.ar'   => ['required', 'max:100', new AlphaNumSpacesRule('ar')],
            'name.en'   => ['required', 'max:100', new AlphaNumSpacesRule('en')],
            'email'     => ['required', 'email'],
            'phone'     => ['required', 'numeric', new PhoneRule($this->request->get('phone_code'))],
            'phone_code' => 'required|exists:countries,calling_code',
            'image'     => 'sometimes|image|max:5120', //5m
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
