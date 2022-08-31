<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use MongoDB\BSON\ObjectId;

class UpdateAttributeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('attribute');

        return [
            'key'           => ['required', Rule::unique('attributes')->ignore(new ObjectId($id), '_id'), 'min:2', 'max:100', 'alpha_dash'],
            'image'         => 'sometimes|nullable|image|max:5120',
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
