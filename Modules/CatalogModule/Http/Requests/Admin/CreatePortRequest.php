<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePortRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|array',
            'name.ar'       => ['nullable', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'name.en'       => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'country_id'    => ['required', new MongoIdRule()],
            'city_id'       => ['required', new MongoIdRule()],
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
            'is_active'     => 'nullable|boolean'
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
