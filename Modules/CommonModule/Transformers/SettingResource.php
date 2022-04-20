<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $title = 'title_' . app()->getLocale();

        return [
            'group'     => $this->group,
            'title'     => $this->{$title},
            'key'       => $this->key,
            'value'     => (in_array($this->type, ['file', 'image']) ? asset('storage/' . $this->value) : $this->value),
            'type'      => $this->type,
            'data'      => $this->data
        ];
    }
}
