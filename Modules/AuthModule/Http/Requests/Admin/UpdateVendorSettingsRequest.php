<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'phone'     => ['required', 'numeric', 'phone'],
            'phone_code' => 'required|exists:countries,calling_code',
            'image'     => 'sometimes|image|max:5120', //5m
            'settings'  => 'nullable|sometimes|array',
            'currency_code' => ['required', Rule::in(array_keys(currencies()))]
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

    /**
     * Validation Data
     *
     * @param $key
     * @param $default
     * @return array
     */
    public function validationData()
    {
        $data  = parent::validationData();
        $data['phone_country'] = getCountryCodeFromPhoneCode(phoneCodeCleaning($this->request->get('phone_code')));
        return $data;
    }
}
