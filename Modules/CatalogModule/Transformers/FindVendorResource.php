<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CommonModule\Transformers\CountryResource;

class FindVendorResource extends JsonResource
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
            'image'     => imageUrl($this->image),
            'email'     => $this->email,
            'phone'     => $this->phone,
            'country'   => new CountryResource($this->country),
            'type'      => $this->type,
            'darbi_percentage' => $this->darbi_percentage,
            'settings'  => $this->settings,
            'lat'       => $this->lat,
            'lng'       => $this->lng,
            'country_currency_code' => $this->country_currency_code,
            'is_active' => (boolean)$this->is_active
        ];
    }
}
