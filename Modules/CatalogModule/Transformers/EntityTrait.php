<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Transformers;

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
        $entityMainImages = $this->images;

        if (empty($entityMainImages) && $onlyEntityImages !== true) {
            $entityMainImages = optional($this->model)->images ?? [$this->defaultImage];
        }

        return array_map(function ($image) { return imageUrl($image); }, $entityMainImages);
    }

    //get entity extras
    private function getExtras()
    {
        $extras = app(ExtraRepository::class)->getExtras(@array_values($this->extra_ids), $this->vendor_id);

        return ExtraResource::collection(
            $extras->map(function ($extra) {
                $extra->price_unit = $this->price_unit;
                return $extra;
            })
        );
    }
}
