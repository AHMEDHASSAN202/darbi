<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateModelRequest extends FormRequest
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
            'name.en'           => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'name.ar'           => ['sometimes', 'nullable', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'brand_id'          => 'required|exists:brands,_id',
            'is_active'         => 'nullable|sometimes|boolean',
            'images'            => 'nullable|sometimes|array',
            'images.*'          => 'required|image|max:5120', //5m
            'specs'             => 'required|array',
            'specs.*'           => 'required|array', //5m
            'specs.*.id'        => ['required', new MongoIdRule()],
            'specs.*.key'       => 'required|min:1|max:100',
            'specs.*.value'     => 'required|min:1|max:200',
            'specs.*.image'     => 'required|url',
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
