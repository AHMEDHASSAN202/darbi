<?php

namespace Modules\BookingModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'entity_type'       => 'required|in:car,yacht',
            'plugins'           => 'nullable|array'
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
