<?php

namespace Modules\CatalogModule\Http\Requests;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;

class ListOfEntitiesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country'         =>  ['sometimes', 'nullable', new MongoIdRule()],
            'city'            =>  ['sometimes', 'nullable', new MongoIdRule()],
            'region'          =>  ['sometimes', 'nullable', new MongoIdRule()],
            'brand'           =>  ['sometimes', 'nullable', new MongoIdRule()],
            'model'           =>  ['sometimes', 'nullable', new MongoIdRule()],
            'from_date'       =>  ['sometimes', 'nullable', 'date'],
            'to_date'         =>  ['sometimes', 'nullable', 'date'],
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
