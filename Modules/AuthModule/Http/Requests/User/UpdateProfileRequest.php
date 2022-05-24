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
        return [
            'name'                      => 'required|min:3,max:50',
            'note'                      => 'sometimes|nullable|min:3|max:500',
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
