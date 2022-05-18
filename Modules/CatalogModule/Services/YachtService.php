<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Repositories\YachtRepository;
use Modules\CatalogModule\Transformers\CarDetailsResource;
use Modules\CatalogModule\Transformers\YachtDetailsResource;
use Modules\CatalogModule\Transformers\YachtResource;
use Modules\CommonModule\Transformers\PaginateResource;

class YachtService
{
    private $yachtRepository;

    public function __construct(YachtRepository $yachtRepository)
    {
        $this->yachtRepository = $yachtRepository;
    }

    public function findAll(Request $request)
    {
        $yachts = $this->yachtRepository->listOfYachts($request);

        return new PaginateResource(YachtResource::collection($yachts));
    }

    public function find($yachtId)
    {
        $yacht = $this->yachtRepository->findYachtWithDetailsById($yachtId);

        abort_if(is_null($yacht), 404);

        return new YachtDetailsResource($yacht);
    }
}
