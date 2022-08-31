<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\VillaRepository;
use Modules\CatalogModule\Transformers\FindVillaResource;
use Modules\CatalogModule\Transformers\VillaResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class VillaService
{
    use EntityHelperService, ImageHelperTrait;

    private $repository;

    public function __construct(VillaRepository $villaRepository)
    {
        $this->repository = $villaRepository;
    }

    public function findAll(Request $request)
    {
        $villas = $this->repository->listOfVillas($request);

        if ($villas instanceof LengthAwarePaginator) {
            return new PaginateResource(VillaResource::collection($villas));
        }

        return VillaResource::collection($villas);
    }

    public function find($villaId)
    {
        $villa = $this->repository->findVillaWithDetailsById($villaId);

        abort_if(is_null($villa), 404);

        return new FindVillaResource($villa);
    }
}
