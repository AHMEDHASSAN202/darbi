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
        $country = $this->country;

        return [
            'id'            => $this->_id,
            'name'          => translateAttribute($this->name),
            'email'         => $this->email,
            'phone'         => $this->phone,
            'phone_code'    => $this->phone_code  ?? @$country['calling_code'],
            'darbi_percentage' => $this->darbi_percentage,
            'image'         => imageUrl($this->image, 'thumbnail'),
            'country_id'    => (string)$this->country_id,
            'country'       => new CountryResource($country),
            'type'          => $this->type,
//            'created_by'    => $this->created_by ? (string)$this->created_by : null,
//            'created_by_name' => optional($this->createdBy)->name,
            'is_active'     => (boolean)$this->is_active,
            'lat'           => (float)$this->lat,
            'lng'           => (float)$this->lng,
            'admins_count'  => $this->getCountAdmin()
        ];
    }
}
