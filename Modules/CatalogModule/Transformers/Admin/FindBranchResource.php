<?php

namespace Modules\CatalogModule\Transformers\Admin;

use App\Proxy\Proxy;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Proxy\CatalogProxy;
use Modules\CommonModule\Transformers\FindCityResource;

class FindBranchResource extends JsonResource
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
            'id'         => (string)$this->_id,
            'name'       => $this->name,
            'cover_images' => imagesUrl(convertBsonArrayToNormalArray($this->cover_images)),
            'is_active'  => (boolean)$this->is_active,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'lat'        => $this->lat ? floatval($this->lat) : null,
            'lng'        => $this->lng ? floatval($this->lng) : null,
            'city_id'    => (string)$this->city_id,
            'city'       => new FindCityResource($this->city),
            'regions'    => $this->getRegions()
        ];
    }


    private function getRegions()
    {
        if (empty($this->regions_ids)) {
            return [];
        }

        $locationProxy = new CatalogProxy('GET_REGIONS', ['in' => generateStringIdOfArrayValues($this->regions_ids)]);
        $proxy = new Proxy($locationProxy);
        return $proxy->result();
    }
}
