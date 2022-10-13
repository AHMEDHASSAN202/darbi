<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Repositories\CarTypeRepository;
use Modules\CommonModule\Transformers\CarTypeResource;
use Modules\CommonModule\Transformers\PaginateResource;

class CarTypeService
{
    private $carTypeRepository;

    public function __construct(CarTypeRepository $carTypeRepository)
    {
        $this->carTypeRepository = $carTypeRepository;
    }

    public function findAll(Request $request)
    {
        $carTypes = $this->carTypeRepository->list($request);

        if ($carTypes instanceof LengthAwarePaginator) {
            return successResponse(['carTypes' => new PaginateResource(CarTypeResource::collection($carTypes))]);
        }

        return successResponse(['carTypes' => CarTypeResource::collection($carTypes)]);
    }
}
