<?php

namespace Modules\NotificationsModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->_id,
            'title'         => translateAttribute($this->title),
            'message'       => translateAttribute($this->message),
            'read_at'       => !is_null($this->getReadAtValue()),
            'extra_data'    => (object)$this->extra_data,
            'notification_type' => $this->notification_type
        ];
    }


    private function getReadAtValue()
    {
        $currentUserArray = [];
        $notificationUsers = $this->receivers ?? [];
        foreach ($notificationUsers as $notificationUser) {
            if ((string)$notificationUser['user_id'] == auth('api')->id() && $notificationUser['on_model'] == 'user') {
                $currentUserArray = $notificationUser;
                break;
            }
        }

        return arrayGet($currentUserArray, 'read_at');
    }
}
