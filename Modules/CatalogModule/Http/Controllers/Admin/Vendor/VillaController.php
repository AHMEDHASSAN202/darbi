<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateVillaRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateVillaRequest;
use Modules\CatalogModule\Services\Admin\VillaService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class VillaController extends Controller
{
    use ApiResponseTrait;

    private $villaService;

    public function __construct(VillaService $villaService)
    {
        $this->villaService = $villaService;
    }

    public function index(Request $request)
    {
        $villas = $this->villaService->findAllByVendor($request);

        return $this->apiResponse(compact('villas'));
    }

    public function show($id)
    {
        $villa = $this->villaService->findByVendor($id);

        return $this->apiResponse(compact('villa'));
    }

    public function store(CreateVillaRequest $createVillaRequest)
    {
        $result = $this->villaService->create($createVillaRequest);

        return $this->apiResponse(...$result);
    }


    public function update($id, UpdateVillaRequest $updateVillaRequest)
    {
        $result = $this->villaService->update($id, $updateVillaRequest);

        return $this->apiResponse(...$result);
    }


    public function destroy($id)
    {
        $result = $this->villaService->delete($id);

        return $this->apiResponse(...$result);
    }


    public function deleteImage($id, $imageIndex)
    {
        $result = $this->villaService->removeImage($id, $imageIndex);

        return $this->apiResponse(...$result);
    }
}
