<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class CreateCarRequest extends CreateEntityRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['branch_id'] = ['required', Rule::exists('branches', '_id')->where('vendor_id', [getVendorId()])];
        $rules['car_type_id'] = 'sometimes|nullable|exists:car_types,_id';
        $rules['color'] = 'sometimes|nullable|array|max:2';
        $rules['color.0.name'] = 'required_with:color.0.color|string|min:2|max:100';
        $rules['color.0.color'] = ['required_with:color.0.name', 'regex:/^#([a-f0-9]{6})$/i'];
        $rules['color.1.name'] = 'required_with:color.1.color|string|min:2|max:100';
        $rules['color.1.color'] = ['required_with:color.1.name', 'regex:/^#([a-f0-9]{6})$/i'];
        return $rules;
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
