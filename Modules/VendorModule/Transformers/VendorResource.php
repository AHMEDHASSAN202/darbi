<?php

namespace Modules\VendorModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'id'        => $this->_id,
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'image'     => $this->image ? asset($this->image) : null,
            'city'      => $this->city,
            'country'   => $this->country,
            'markup'    => $this->markup,
            'is_yacht_provider' => (bool)$this->is_yacht_provider,
            'info'      => $this->info,
            'settings'  => is_string($this->settings) ? json_decode($this->settings) : $this->settings
        ];
    }
}
