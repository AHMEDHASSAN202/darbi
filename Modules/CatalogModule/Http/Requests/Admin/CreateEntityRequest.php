<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEntityRequest extends FormRequest
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
            'name.ar'           => ['sometimes', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'name.en'           => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'model_id'          => ['required', 'exists:models,_id'],
            'images'            => 'nullable|sometimes|array',
            'images.*'          => 'nullable|sometimes|image|max:5120', //5m
            'extra_ids'         => 'nullable|array',
            'extra_ids.*'       => ['nullable', new MongoIdRule()],
            'price'             => 'required|numeric',
            'price_unit'        => 'required|in:day,hour',
            'unavailable_date'  => 'nullable|array',
            'unavailable_date.*' => 'nullable|date',
            'is_active'         => 'nullable|sometimes|boolean',
            'built_date'        => 'nullable|sometimes|date_format:Y|before_or_equal:today',
            'attributes'        => 'sometimes|nullable|array',
            'attributes.*'      => 'sometimes|nullable|array', //5m
            'attributes.*.id'   => ['required', new MongoIdRule()],
            'attributes.*.key'  => 'required|min:1|max:100',
            'attributes.*.value'=> 'required|min:1|max:100',
            'attributes.*.image'=> 'required|url',
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
