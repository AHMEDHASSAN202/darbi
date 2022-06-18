<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Repositories\YachtRepository;
use Modules\CatalogModule\Services\Admin\EntityHelperService;
use Modules\CatalogModule\Transformers\FindYachtResource;
use Modules\CatalogModule\Transformers\YachtResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class YachtService
{
    use EntityHelperService, ImageHelperTrait;


    private $repository;
    private $uploadDirectory = 'yachts';

    public function __construct(YachtRepository $yachtRepository)
    {
        $this->repository = $yachtRepository;
    }

    public function findAll(Request $request)
    {
        $yachts = $this->repository->listOfYachts($request);

        return new PaginateResource(YachtResource::collection($yachts));
    }

    public function find($yachtId)
    {
        $yacht = $this->repository->findYachtWithDetailsById($yachtId);

        abort_if(is_null($yacht), 404);

        return new FindYachtResource($yacht);
    }
}
