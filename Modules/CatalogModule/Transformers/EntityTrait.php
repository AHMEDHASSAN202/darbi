<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Transformers;

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
    private function getImagesFullPath() : array
    {
        $entityMainImages = $this->images;

        if (empty($entityMainImages)) {
            $entityMainImages = optional($this->model)->images ?? [$this->defaultImage];
        }

        return array_map(function ($image) { return imageUrl($image); }, $entityMainImages);
    }


    private function getPlugins()
    {
        $plugins = $this->plugins->map(function ($plugin) {
            $plugin->price_unit = $this->price_unit;
            return $plugin;
        });

        return PluginResource::collection($plugins);
    }
}
