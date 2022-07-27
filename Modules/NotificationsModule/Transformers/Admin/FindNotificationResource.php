<?php

namespace Modules\NotificationsModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FindNotificationResource extends JsonResource
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
            'title'         => $this->title,
            'message'       => $this->message,
            'extra_data'    => (object)$this->extra_data,
            'notification_type' => $this->notification_type,
            'receiver_type' => $this->receiver_type,
            'image'         => imageUrl($this->image),
            'url'           => $this->url,
            'receivers'     => $this->receivers ? array_map(function ($receiver) { return ['user_id' => (string)$receiver['user_id'], 'type' => $receiver['on_model']]; }, $this->receivers) : []
        ];
    }
}
