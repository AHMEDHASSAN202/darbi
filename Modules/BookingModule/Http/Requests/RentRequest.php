<?php

namespace Modules\BookingModule\Http\Requests;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\CatalogModule\Enums\EntityType;

class RentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entity_id'         => 'required',
            'entity_type'       => ['required', Rule::in(array_values(EntityType::getTypes()))],
            'plugins'           => 'nullable|array',
            'city_id'           => ['required', new MongoIdRule]
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
