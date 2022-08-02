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
            'extra_data'    => (object)$this->extra_data,
            'notification_type' => $this->notification_type,
            'created_at'    => $this->created_at
        ];
    }
}
