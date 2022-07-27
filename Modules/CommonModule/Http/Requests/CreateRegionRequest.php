<?php

namespace Modules\CommonModule\Http\Requests;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRegionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required|array',
            'name.ar'      => ['required', new AlphaNumSpacesRule('ar')],
            'name.en'      => ['required', new AlphaNumSpacesRule('en')],
            'is_active'    => 'nullable|boolean',
            'location'     => 'required|array|min:3',
            'location.*.lat' => 'required|numeric',
            'location.*.lng' => 'required|numeric'
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
