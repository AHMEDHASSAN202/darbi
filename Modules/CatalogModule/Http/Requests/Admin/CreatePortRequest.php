<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

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
            'name.ar'       => 'required|min:2|max:100',
            'name.en'       => 'required|min:2|max:100',
            'country_id'    => ['required', new MongoIdRule(), Rule::exists('countries', '_id')],
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
