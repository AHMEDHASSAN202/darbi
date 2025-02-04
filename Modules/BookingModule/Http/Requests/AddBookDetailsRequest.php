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
            'pickup_location'   => 'sometimes|nullable|array',
            'pickup_location.id'=> ['sometimes', new MongoIdRule()],
            'drop_location'     => 'sometimes|nullable|array',
            'drop_location.id'  => ['sometimes', new MongoIdRule()],
            'note'              => 'sometimes|nullable|max:500',
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
