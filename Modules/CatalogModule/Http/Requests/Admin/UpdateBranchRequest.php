<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
            'name.ar'       => 'required|min:2|max:100',
            'name.en'       => 'required|min:2|max:100',
            'address'       => 'required|min:2|max:100',
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
            'cover_images'  => 'nullable|sometimes|array',
            'cover_images.*'=> 'nullable|sometimes|image|max:5120',
            'is_active'     => 'nullable|sometimes|boolean',
            'phone'         => 'nullable|sometimes|array',
            'phone'         => 'nullable|sometimes|numeric|digits_between:8,11',
            'phone_code'    => 'required_with:phone'
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
