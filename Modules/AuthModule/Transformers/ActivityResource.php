<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'id'            => $this->id,
            'log_name'      => $this->log_name,
            'description'   => $this->description,
            'model'         => $this->model,
            'changes'       => (object)$this->changes,
            'properties'    => (object)$this->properties,
            'created_at'    => $this->created_at
        ];
    }
}
