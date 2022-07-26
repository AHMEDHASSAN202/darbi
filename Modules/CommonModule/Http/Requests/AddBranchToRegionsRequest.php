<?php

namespace Modules\CommonModule\Http\Requests;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;

class AddBranchToRegionsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branch_id'      => ['required', new MongoIdRule],
            'regions_ids'    => ['required', 'array'],
            'regions_ids.*'  => ['required', new MongoIdRule]
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
