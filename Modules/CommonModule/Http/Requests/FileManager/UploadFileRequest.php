<?php

namespace Modules\CommonModule\Http\Requests\FileManager;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file'          => 'required|file|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf,mp4,mov,ogg,qt|max:51200', //50m
            'upload_path'   => 'required'
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
