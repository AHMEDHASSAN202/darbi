<?php

namespace Modules\AuthModule\Http\Requests\User;

use App\Rules\PhoneRule;
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
        $this->request->set('phone_code', phoneCodeCleaning($this->request->get('phone_code')));

        return [
            'phone'         => ['required', 'numeric', new PhoneRule($this->request->get('phone_code'))],
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



}
