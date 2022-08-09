<?php

namespace Modules\AuthModule\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'         => ['required', 'numeric', 'phone:phone_country,mobile'],
            'phone_code'    => 'required'
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
