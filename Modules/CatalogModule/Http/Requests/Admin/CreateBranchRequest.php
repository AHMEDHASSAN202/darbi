<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBranchRequest extends FormRequest
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
            'name.ar'       => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'name.en'       => ['nullable', 'sometimes', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'address'       => 'required|min:2|max:100',
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
            'cover_images'  => 'nullable|sometimes|array',
            'cover_images.*'=> 'nullable|sometimes|image|max:5120',
            'is_active'     => 'nullable|sometimes|boolean',
            'phone'         => ['nullable', 'sometimes', 'numeric', new PhoneRule($this->request->get('phone_code'))],
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
