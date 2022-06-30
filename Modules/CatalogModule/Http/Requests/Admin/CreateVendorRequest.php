<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateVendorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'name.en'           => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'name.ar'           => ['sometimes', 'nullable', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'is_active'         => 'nullable|sometimes|boolean',
            'image'             => 'required|image|max:5120', //5
            'phone'             => ['required', 'numeric', new PhoneRule($this->request->get('phone_code'))],
            'phone_code'        => 'required_with:phone',
            'email'             => 'required|email',
            'darbi_percentage'  => 'nullable|sometimes|numeric',
            'country_id'        => 'required|exists:countries,_id',
            'settings'          => 'nullable|sometimes|array'
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
