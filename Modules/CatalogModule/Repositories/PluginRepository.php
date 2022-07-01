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
        $query = $this->model->latest()->filters($request)->search($request);

        if ($onlyActive) {
            $query->active();
        }

        $paginated = $request->has('paginated');

        if ($paginated) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }
}
