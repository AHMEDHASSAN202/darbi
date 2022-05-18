<?php

namespace Modules\CommonModule\Http\Requests\FileManager;

use Illuminate\Foundation\Http\FormRequest;

class MoveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_path'     => 'required',
            'to_path'       => 'required',
            'file'          => 'required_if:type,file|max:100',
            'use_copy'      => 'nullable|boolean',
            'type'          => 'nullable|in:file,directory'
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
