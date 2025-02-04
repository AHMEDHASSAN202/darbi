<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Modules\CatalogModule\Entities\Plugin;
use Modules\CommonModule\Traits\CrudRepositoryTrait;

class PluginRepository
{
    use CrudRepositoryTrait;

    private $model;

    public function __construct(Plugin $model)
    {
        $this->model = $model;
    }

    public function findAll($request, $onlyActive = true)
    {
        return $this->model->latest()->filters($request)->search($request)->when($onlyActive, function ($q) { $q->active(); })->paginated();
    }
}
