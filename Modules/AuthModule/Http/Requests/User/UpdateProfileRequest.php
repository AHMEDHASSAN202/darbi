<?php

namespace Modules\AuthModule\Http\Requests\User;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'name'                      => ['required', 'min:3', 'max:50', new AlphaNumSpacesRule()],
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
