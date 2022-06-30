<?php

namespace Modules\BookingModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProceedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method'        => 'required|in:cash,apple_pay',
            'transaction'           => 'required_if:payment_method,apple_pay|array'
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
