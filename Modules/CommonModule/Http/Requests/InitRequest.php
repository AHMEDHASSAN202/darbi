<?php

namespace Modules\CommonModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'platform'          => 'required|in:android,ios',
            'version'           => 'required|numeric'
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
