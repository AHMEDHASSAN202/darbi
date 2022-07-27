<?php

namespace Modules\BookingModule\Http\Requests\Web;

use App\Rules\AlphaNumSpacesRule;
use App\Rules\MobileDigits;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => ['required', new AlphaNumSpacesRule()],
            'age'                   => 'required|numeric',
            'mobile'                => ['required', 'numeric', new PhoneRule($this->request->get('mobile_code'))],
            'email'                 => 'nullable|email',
            'country'               => ['required', new AlphaNumSpacesRule()],
            'annual_travels_count'  => 'required|numeric',
            'travel_reasons'        => 'required',
            'destination'           => ['required', new AlphaNumSpacesRule()],
            'preferred_car_brand'   => 'required|exists:brands,_id',
            'preferred_method'      => 'required|in:rental,taxi,public_transport',
            'payment_rate'          => 'required|numeric',
            'with_driver'           => 'required|in:1,0',
            'preferred_pickup_place'=> 'required|in:airport,hotel',
            'preferred_delivery_place' => 'required|in:airport,hotel',
            'mobile_code'           => 'required|in:966,971',
            'country_code'          => 'required|in:sa,ae'
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
