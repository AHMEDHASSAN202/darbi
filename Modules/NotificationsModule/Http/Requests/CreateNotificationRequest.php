<?php

namespace Modules\NotificationsModule\Http\Requests;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\NotificationsModule\Enums\NotificationReceiverTypes;
use Modules\NotificationsModule\Enums\NotificationTypes;

class CreateNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|array',
            'title.ar'      => 'required|string',
            'title.en'      => 'required|string',
            'message'       => 'required|array',
            'message.ar'    => 'required|string',
            'message.en'    => 'required|string',
            'url'           => 'sometimes|nullable|url',
            'notification_type' => 'required|string|in:'.implode(',', array_values(NotificationTypes::getTypes())),
            'receiver_type'     => 'required|in:'.implode(',', array_values(NotificationReceiverTypes::getTypes())),
            'receivers'         => 'required_if:receiver_type,'.NotificationReceiverTypes::SPECIFIED.'|array|max:500',
            'receivers.*.id'    => ['required', new MongoIdRule],
            'receivers.*.type'  => ['required', 'in:user,vendor'],
            'image'             => 'sometimes|nullable|image',
            'extra_data'        => 'sometimes|nullable|array',
            'is_automatic'      => 'sometimes|nullable|boolean'
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
