<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Transformers\EntityTrait;
use Modules\CommonModule\Transformers\CityResource;
use Modules\CommonModule\Transformers\CountryResource;

class FindEntityResource extends JsonResource
{
    use EntityTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $res = [
            'id'            => $this->_id,
            'name'          => $this->name,
            'images'        => $this->getImagesFullPath(true),
            'brand'         => new BrandResource($this->brand),
            'brand_id'      => (string)$this->brand_id,
            'model'         => new ModelResource($this->model),
            'model_id'      => (string)$this->model_id,
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'is_active'     => (boolean)$this->is_active,
            'unavailable_date'  => $this->unavailable_date,
            'country_id'    => (string)$this->country_id,
            'country'       => new CountryResource($this->country),
            'city_id'       => (string)$this->city_id,
            'city'          => new CityResource($this->city),
            'extras'        => FindExtraResource::collection(convertBsonArrayToCollection($this->attachPluginToExtra($this->extras, $this->plugins)))
        ];

        if ($this->resource instanceof Yacht) {
            $res['port_id'] = (string)$this->port_id;
            $res['port']    = new PortResource($this->port);
        }elseif ($this->resource instanceof Car) {
            $res['branches'] = BranchResource::collection(convertBsonArrayToCollection($this->branches));
        }

        return $res;
    }
}
