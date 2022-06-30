<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;

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
        $rules['branch_ids']    = 'required|array';
        $rules['branch_ids.*']  = ['required', new MongoIdRule()];
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
