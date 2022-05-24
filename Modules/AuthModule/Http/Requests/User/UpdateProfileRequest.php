<?php

namespace Modules\AuthModule\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\AuthModule\Services\UserAuthService;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $me = app(UserAuthService::class)->authUser();

        return [
            'name'                      => 'required|min:3,max:50',
            'phone'                     => ['required', 'numeric', 'digits_between:8,11', Rule::unique('users', 'phone')->where('phone_code', $me->phone_code)->ignore($me->_id, '_id')],
            'email'                     => 'sometimes|nullable|email|unique:users',
            'identity_frontside_image'  => 'sometimes|nullable|image|max:5120', //5m
            'identity_backside_image'   => 'sometimes|nullable|image|max:5120', //5m
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
