<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttributeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key'           => 'required|unique:attributes|min:2|max:100',
            'image'         => 'required|image|max:5120',
            'entity_type'   => 'required|array',
            'entity_type.*' => 'required|in:car,yacht,villa',
            'type'          => 'required|array',
            'type.*'        => 'required|in:model,entity'
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
