<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Villa;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Transformers\EntityTrait;
use Modules\CommonModule\Transformers\CarTypeResource;
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
            'vendor_id'     => (string)$this->vendor_id,
//            'vendor'        => new VendorResource($this->vendor),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'is_active'     => (boolean)$this->is_active,
            'unavailable_date'  => $this->unavailable_date,
            'extras'        => FindExtraResource::collection(convertBsonArrayToCollection($this->attachPluginToExtra($this->extras, $this->plugins))),
            'built_date'    => $this->built_date ? (int)$this->built_date : null,
            'attributes'    => convertBsonArrayToArray($this->attributes)
        ];

        if ($this->resource instanceof Yacht) {
            $res['port_id'] = (string)$this->port_id;
            $res['port']    = new PortResource($this->port);
        }elseif ($this->resource instanceof Car) {
            $res['branch_id'] = (string)$this->branch_id;
            $res['branch'] = new BranchResource($this->branch);
            $res['color'] = convertBsonArrayToArray($this->color);
            $res['car_type_id'] = (string)$this->car_type_id;
            $res['car_type'] = new CarTypeResource($this->car_type);
        }

        if ($this->resource instanceof Villa) {
            $res['city_id'] = (string)$this->city_id;
            $res['city'] = new CityResource($this->city);
            $res['location'] = $this->location;
        }else {
            $res['brand'] = new BrandResource($this->brand);
            $res['brand_id'] = (string)$this->brand_id;
            $res['model'] = new ModelResource($this->model);
            $res['model_id'] = (string)$this->model_id;
        }

        return $res;
    }
}
