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
            'pickup_location'   => 'required|array',
//            'pickup_location.lat' => 'required|numeric',
//            'pickup_location.lng' => 'required|numeric',
//            'pickup_location.fully_addressed' => 'required|string',
//            'pickup_location.city' => 'required|string',
//            'pickup_location.country' => 'required|string',
//            'pickup_location.region_id' => ['required', new MongoIdRule()],
            'drop_location'     => 'required|array',
//            'drop_location.lat' => 'required|numeric',
//            'drop_location.lng' => 'required|numeric',
//            'drop_location.fully_addressed' => 'required|string',
//            'drop_location.city' => 'required|string',
//            'drop_location.country' => 'required|string',
//            'drop_location.region_id' => ['required', new MongoIdRule()],
            'note'               => 'sometimes|nullable|max:500',
            'start_at'          => 'required|date|after_or_equal:today',
            'end_at'            => 'required|date|after_or_equal:start_at',
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
