<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Plugin;

class PluginRepository
{
    private $model;

    public function __construct(Plugin $model)
    {
        $this->model = $model;
    }

    public function findAllPluginByCar($carId)
    {
        return $this->model->active()->whereHas('entities', function ($query) use ($carId) { $query->where('_id', $carId); })->get();
    }
}
