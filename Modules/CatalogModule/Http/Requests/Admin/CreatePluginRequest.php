<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
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
            'name.ar'   => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'name.en'   => ['nullable', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'desc.ar'   => 'required|min:2|max:500',
            'desc.en'   => 'nullable|min:2|max:500',
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
