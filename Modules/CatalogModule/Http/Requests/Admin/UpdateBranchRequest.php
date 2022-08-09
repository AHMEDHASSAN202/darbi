<?php

namespace Modules\CatalogModule\Http\Requests\Admin;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\MongoIdRule;
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
            'name.ar'       => ['nullable', 'sometimes', 'min:2', 'max:100', new AlphaNumSpacesRule('ar')],
            'name.en'       => ['required', 'min:2', 'max:100', new AlphaNumSpacesRule('en')],
            'address'       => 'required|min:2|max:200',
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
            'cover_images'  => 'nullable|sometimes|array',
            'cover_images.*'=> 'nullable|sometimes|image|max:5120',
            'is_active'     => 'nullable|sometimes|boolean',
            'phone'         => 'nullable|sometimes|array',
            'phone'         => ['nullable', 'sometimes', 'numeric', 'phone:phone_country,mobile'],
            'phone_code'    => 'required_with:phone',
            'city_id'       => 'required|exists:cities,_id',
            'region_ids'    => 'sometimes|nullable|array',
            'region_ids.*'  => ['required', new MongoIdRule()]
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

    /**
     * Validation Data
     *
     * @param $key
     * @param $default
     * @return array
     */
    public function validationData()
    {
        $data  = parent::validationData();
        $data['phone_country'] = getCountryCodeFromPhoneCode(phoneCodeCleaning($this->request->get('phone_code')));
        return $data;
    }
}
