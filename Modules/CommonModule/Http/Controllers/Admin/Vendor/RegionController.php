<?php

namespace Modules\CommonModule\Http\Controllers\Admin\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\CreateRegionRequest;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;
use Modules\CommonModule\Http\Requests\UpdateRegionRequest;
use Modules\CommonModule\Http\Requests\ValidateLatAndLngRequest;
use Modules\CommonModule\Services\RegionService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

class RegionController extends Controller
{
    use ApiResponseTrait;

    private $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function index(Request $request)
    {
        $result = $this->regionService->regionsByVendor($request);

        return $this->apiResponse(...$result);
    }

    public function find($id)
    {
        $result = $this->regionService->regionByVendor($id);

        return $this->apiResponse(...$result);
    }

    public function store(CreateRegionRequest $createRegionRequest)
    {
        $result = $this->regionService->create($createRegionRequest);

        return $this->apiResponse(...$result);
    }

    public function update($id, UpdateRegionRequest $updateRegionRequest)
    {
        $result = $this->regionService->update($id, $updateRegionRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($id)
    {
        $result = $this->regionService->destroy($id);

        return $this->apiResponse(...$result);
    }
}
