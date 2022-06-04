<?php

namespace Modules\BookingModule\Http\Requests;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;

class AddBookDetailsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_at'          => 'required|date|after_or_equal:today',
            'end_at'            => 'required|date|after_or_equal:start_at',
            'pickup_location'   => 'required|array',
            'pickup_location.lat' => 'required|numeric',
            'pickup_location.lng' => 'required|numeric',
            'pickup_location.region_id' => ['required', new MongoIdRule()],
            'drop_location'     => 'required|array',
            'drop_location.lat' => 'required|numeric',
            'drop_location.lng' => 'required|numeric',
            'drop_location.region_id' => ['required', new MongoIdRule()],
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
