<?php

namespace Modules\NotificationsCenterModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsCenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
