<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateYachtRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateYachtRequest;
use Modules\CatalogModule\Services\Admin\YachtService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class YachtController extends Controller
{
    use ApiResponseTrait;

    private $yachtService;

    public function __construct(YachtService $yachtService)
    {
        $this->yachtService = $yachtService;
    }

    public function index(Request $request)
    {
        $yachts = $this->yachtService->findAllByVendor($request);

        return $this->apiResponse(compact('yachts'));
    }

    public function show($id)
    {
        $yacht = $this->yachtService->findByVendor($id);

        return $this->apiResponse(compact('yacht'));
    }

    public function store(CreateYachtRequest $createYachtRequest)
    {
        $yacht = $this->yachtService->create($createYachtRequest);

        return $this->apiResponse(compact('yacht'), 201, __('Data has been added successfully'));
    }


    public function update($id, UpdateYachtRequest $updateYachtRequest)
    {
        $yacht = $this->yachtService->update($id, $updateYachtRequest);

        return $this->apiResponse(compact('yacht'), 200, __('Data has been updated successfully'));
    }


    public function destroy($id)
    {
        $result = $this->yachtService->delete($id);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function deleteImage($id, $imageIndex)
    {
        $this->yachtService->removeImage($id, $imageIndex);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
