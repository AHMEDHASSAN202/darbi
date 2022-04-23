<?php

namespace Modules\FileManagerModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDirectoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'path'           => 'required',
            'directory_name' => 'required|max:100'
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
