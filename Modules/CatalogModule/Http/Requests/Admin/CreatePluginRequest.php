<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreatePluginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|array',
            'name.ar'   => 'required|min:2|max:100',
            'name.en'   => 'required|min:2|max:100',
            'desc.ar'   => 'required|min:2|max:500',
            'desc.en'   => 'required|min:2|max:500',
            'is_active' => 'nullable|boolean'
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
