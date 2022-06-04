<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Repositories\PortRepository;
use Modules\CatalogModule\Transformers\BrandResource;
use Modules\CatalogModule\Transformers\PortResource;
use Modules\CommonModule\Transformers\PaginateResource;

class PortService
{
    private $portRepository;

    public function __construct(PortRepository $portRepository)
    {
        $this->portRepository = $portRepository;
    }

    public function findAll(Request $request)
    {
        $ports = $this->portRepository->listOfPorts($request);

        if ($ports instanceof LengthAwarePaginator) {
            return new PaginateResource(PortResource::collection($ports));
        }

        return PortResource::collection($ports);
    }
}
