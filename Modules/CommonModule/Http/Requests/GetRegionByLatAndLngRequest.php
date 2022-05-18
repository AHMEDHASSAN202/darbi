<?php

namespace Modules\CommonModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetRegionByLatAndLngRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric'
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
