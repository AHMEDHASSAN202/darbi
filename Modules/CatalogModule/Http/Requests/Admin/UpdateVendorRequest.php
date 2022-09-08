<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVendorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'name.en'           => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'name.ar'           => ['sometimes', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'is_active'         => 'nullable|sometimes|boolean',
            'image'             => 'nullable|image|max:5120', //5
            'phone'             => ['required', 'numeric', 'phone:phone_country,mobile'],
            'phone_code'        => 'required_with:phone',
            'email'             => 'required|email',
            'darbi_percentage'  => 'nullable|sometimes|numeric',
            'settings'          => 'nullable|sometimes|array',
            'lat'               => 'required|numeric',
            'lng'               => 'required|numeric',
            'currency_code'     => ['required', Rule::in(array_keys(currencies()))]
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
