<?php

namespace Modules\NotificationsModule\Http\Requests;

use App\Rules\MongoIdRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
        $rules = [
            'title'         => 'required|array',
            'title.ar'      => 'required|string',
            'title.en'      => 'required|string',
            'message'       => 'required|array',
            'message.ar'    => 'required|string',
            'message.en'    => 'required|string',
            'url'           => 'sometimes|nullable|url',
            'notification_type' => 'required|string|in:'.implode(',', array_values(NotificationTypes::getTypes())),
            'receiver_type'     => 'required|in:'.implode(',', array_values(NotificationReceiverTypes::getTypes())),
            'image'             => 'sometimes|nullable|image',
            'extra_data'        => 'sometimes|nullable|array',
            'is_automatic'      => 'sometimes|nullable|boolean'
        ];

        if (!$this->hasFile('receivers_file')) {
            $rules['receivers']         = ['required_if:receiver_type,'.NotificationReceiverTypes::SPECIFIED, '|array'];
            $rules['receivers.*.id']    = ['required', new MongoIdRule];
            $rules['receivers.*.type']  = ['required', 'in:user,admin'];
        }else {
            $rules['receivers_file'] = 'required|file|mimes:csv,xlsx|max:5120';
        }

        return $rules;
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
