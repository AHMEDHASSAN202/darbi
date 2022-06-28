<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            'logo'          => 'required|image|max:5120',
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
