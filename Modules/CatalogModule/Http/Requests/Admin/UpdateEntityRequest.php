<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEntityRequest extends FormRequest
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
            'name.en'           => 'required|min:2|max:100',
            'name.ar'           => 'sometimes|min:2|max:100',
            'model_id'          => ['required', new MongoIdRule()],
            'images'            => 'nullable|sometimes|array',
            'images.*'          => 'nullable|sometimes|image|max:5120', //5m
            'plugin_ids'        => 'required|array',
            'plugin_ids.*'      => ['required', new MongoIdRule()],
            'country_id'        => ['required', new MongoIdRule()],
            'city_id'           => ['required', new MongoIdRule()],
            'price'             => 'required|numeric',
            'price_unit'        => 'required|in:day,hour',
            'unavailable_date'  => 'required|array',
            'unavailable_date.*' => 'required|date',
            'is_active'         => 'nullable|sometimes|boolean'
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
