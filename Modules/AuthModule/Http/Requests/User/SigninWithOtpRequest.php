<?php

namespace Modules\AuthModule\Http\Requests\User;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class SigninWithOtpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $phoneCode = phoneCodeCleaning($this->request->get('phone_code'));
        request()->offsetSet('phone_code', $phoneCode);

        return [
            'phone'         => ['required', 'numeric', new PhoneRule($phoneCode)],
            'phone_code'    => 'required',
            'otp'           => 'required|numeric'
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
