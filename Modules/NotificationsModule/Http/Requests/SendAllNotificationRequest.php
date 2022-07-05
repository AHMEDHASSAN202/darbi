<?php

namespace Modules\NotificationsModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendAllNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|string',
            'subtitle'      => 'sometimes|nullable|string',
            'url'           => 'sometimes|nullable|url'
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
