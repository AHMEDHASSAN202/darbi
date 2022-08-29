<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\MongoIdRule;
use Illuminate\Validation\Rule;
use MongoDB\BSON\ObjectId;

class UpdateCarRequest extends UpdateEntityRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['branch_id']  = ['required', Rule::exists('branches', '_id')->where('vendor_id', [new ObjectId(getVendorId())])];
        $rules['color.name'] = 'sometimes|nullable|required_with:color.name|string|min:2|max:100';
        $rules['color.color'] = ['sometimes', 'nullable', 'required_with:color.color', 'regex:/^#([a-f0-9]{8})$/i'];
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
