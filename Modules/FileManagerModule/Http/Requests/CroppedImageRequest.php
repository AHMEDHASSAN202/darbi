<?php

namespace Modules\FileManagerModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CroppedImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'w'         => 'required|numeric',
            'h'         => 'required|numeric',
            'y'         => 'required|numeric',
            'x'         => 'required|numeric',
            'image'     => 'required'
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
