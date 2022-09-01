<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Transformers;

use Modules\CatalogModule\Repositories\ExtraRepository;
use Modules\CatalogModule\Services\VendorService;

trait EntityTrait
{
    private $defaultImage = '';


    //this object maybe car or yacht
    private function getMainImage($displayType = 'middle') : string
    {
        $entityMainImage = @$this->images[0];

        if (!$entityMainImage) {
            $modelImages = optional($this->model)->images;
            if ($modelImages && is_array($modelImages)) {
                $entityMainImage = $modelImages[0];
            }
        }

        return imageUrl($entityMainImage ?? $this->defaultImage, $displayType);
    }


    //get entity images
    private function getImagesFullPath($onlyEntityImages = false, $displayType = 'middle') : array
    {
        $entityMainImages = @(array)$this->images;

        if (empty($entityMainImages) && $onlyEntityImages !== true) {
            $entityMainImages = @(array)optional($this->model)->images ?? [$this->defaultImage];
        }

        if (!is_array($entityMainImages)) {
            return [];
        }

        return array_map(function ($image) use ($displayType) { return imageUrl($image, $displayType); }, $entityMainImages);
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
        $vendor = app(VendorService::class)->findOne($this->vendor_id);
        return [
            'id'     => objectGet($vendor, 'id'),
            'type'   => objectGet($vendor, 'type'),
            'phone'  => objectGet($vendor, 'phone'),
            'lat'    => objectGet($vendor, 'lat'),
            'lng'    => objectGet($vendor, 'lng'),
            'currency_code' => objectGet($vendor, 'country_currency_code')
        ];
    }


    private function getAttributes()
    {
        $privateAttributes = $this->attributes ? convertBsonArrayToNormalArray($this->attributes) : [];
        $specs = optional($this->model)->specs ? convertBsonArrayToNormalArray(optional($this->model)->specs) : [];

        $attributes = $privateAttributes + $specs;

        if (empty($attributes) || !is_array($attributes)) {
            return [];
        }

        return SpecsResource::collection(array_values($attributes));
    }
}
