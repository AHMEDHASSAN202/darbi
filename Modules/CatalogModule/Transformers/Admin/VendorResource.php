<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CommonModule\Transformers\CountryResource;

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
            'id'            => $this->_id,
            'name'          => translateAttribute($this->name),
            'email'         => $this->email,
            'phone'         => $this->phone,
            'darbi_percentage' => $this->darbi_percentage,
            'image'         => imageUrl($this->image),
            'country_id'    => (string)$this->country_id,
            'country'       => new CountryResource($this->country),
            'type'          => $this->type,
        ];
    }
}
