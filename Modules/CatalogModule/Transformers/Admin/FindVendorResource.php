<?php

namespace Modules\CatalogModule\Transformers\Admin;

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
        $country = $this->country;

        return [
            'id'            => $this->_id,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'phone_code'    => $this->phone_code ?? @$country['calling_code'],
            'darbi_percentage' => $this->darbi_percentage,
            'image'         => imageUrl($this->image),
            'country_id'    => (string)$this->country_id,
            'country'       => new CountryResource($country),
            'is_active'     => (boolean)$this->is_active,
            'type'          => $this->type,
            'settings'      => is_string($this->settings) ? json_decode($this->settings) : $this->settings,
            'lat'           => (float)$this->lat,
            'lng'           => (float)$this->lng
        ];
    }
}
