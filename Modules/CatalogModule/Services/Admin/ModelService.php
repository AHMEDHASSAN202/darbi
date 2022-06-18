<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\ModelRepository;
use Modules\CatalogModule\Transformers\Admin\ModelResource;
use Modules\CommonModule\Transformers\PaginateResource;

class ModelService
{
    private $modelRepository;

    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    public function findAllForDashboard(Request $request, $onlyActive = true)
    {
        $wheres = [];
        if ($onlyActive) {
            $wheres['is_active'] = true;
        }

        $models = $this->modelRepository->listOfModelsForDashboard($request, $wheres);

        if ($models instanceof LengthAwarePaginator) {
            return new PaginateResource(ModelResource::collection($models));
        }

        return ModelResource::collection($models);
    }
}
