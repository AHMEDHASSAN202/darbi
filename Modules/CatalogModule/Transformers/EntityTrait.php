<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Transformers;

use App\Proxy\Proxy;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\CatalogModule\Repositories\ExtraRepository;

trait EntityTrait
{
    private $defaultImage = '';


    //this object maybe car or yacht
    private function getMainImage() : string
    {
        $entityMainImage = @$this->images[0];

        if (!$entityMainImage) {
            $modelImages = optional($this->model)->images;
            if ($modelImages && is_array($modelImages)) {
                $entityMainImage = $modelImages[0];
            }
        }

        return imageUrl($entityMainImage ?? $this->defaultImage);
    }


    //get entity images
    private function getImagesFullPath($onlyEntityImages = false) : array
    {
        $entityMainImages = @(array)$this->images;

        if (empty($entityMainImages) && $onlyEntityImages !== true) {
            $entityMainImages = @(array)optional($this->model)->images ?? [$this->defaultImage];
        }

        if (!is_array($entityMainImages)) {
            return [];
        }

        return array_map(function ($image) { return imageUrl($image); }, $entityMainImages);
    }


    //get entity extras
    private function getExtras()
    {
        if (empty($this->extra_ids)) {
            return [];
        }

        $extras = app(ExtraRepository::class)->getExtras(@array_values($this->extra_ids), $this->vendor_id);

        return ExtraResource::collection(
            $extras->map(function ($extra) {
                $extra->price_unit = $this->price_unit;
                return $extra;
            })
        );
    }


    private function attachPluginToExtra($extras, $plugins)
    {
        foreach ($extras as $key => $extra) {
           $extra->plugin = collect($plugins)->where('_id', $extra->plugin_id)->first();
           $extras[$key] = $extra;
        }
        return $extras;
    }


    private function getVendor()
    {
        $vendorId = $this->vendor_id;
        $vendor = (new Proxy(new BookingProxy('GET_VENDOR', ['vendor_id' => $vendorId])))->result();
        if (isset($vendor['darbi_percentage'])) unset($vendor['darbi_percentage']);
        if (isset($vendor['settings'])) unset($vendor['settings']);
        return $vendor;
    }
}
