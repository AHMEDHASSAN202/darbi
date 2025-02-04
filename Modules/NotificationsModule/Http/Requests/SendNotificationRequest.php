<?php

namespace Modules\NotificationsModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tokens'        => 'required|array',
            'type'          => 'required|in:all,custom',
            'title'         => 'required|string',
            'message'       => 'required|string',
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
