<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateVendorRequest extends FormRequest
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
            'name.ar'           => ['sometimes', 'nullable', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'is_active'         => 'nullable|sometimes|boolean',
            'image'             => 'required|image|max:5120', //5
            'phone'             => ['required', 'numeric', 'phone:phone_country,mobile'],
            'phone_code'        => 'required_with:phone',
            'email'             => 'required|email|unique:vendors,email',
            'admin_email'       => 'required|email|unique:admins,email',
            'darbi_percentage'  => 'nullable|sometimes|numeric',
            'country_id'        => 'required|exists:countries,_id',
            'settings'          => 'nullable|sometimes|array',
            'password'          => ['required', Password::min(8)->letters(), 'confirmed'],
            'lat'               => 'required|numeric',
            'lng'               => 'required|numeric',
            'type'              => 'required|array',
            'type.*'            => 'required|in:car,yacht,villa',
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
