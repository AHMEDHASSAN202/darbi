<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateCarRequest;
use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\CreateExtraRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateCarRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateExtraRequest;
use Modules\CatalogModule\Services\CarService;
use Modules\CatalogModule\Services\ExtraService;
use Modules\CatalogModule\Services\PluginService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

class CarController extends Controller
{
    use ApiResponseTrait;

    private $carService;


    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        $cars = $this->carService->findAllByVendor($request);

        return $this->apiResponse(compact('cars'));
    }

    public function show($id)
    {
        $car = $this->carService->findByVendor($id);

        return $this->apiResponse(compact('car'));
    }

    public function store(CreateCarRequest $createCarRequest)
    {
        $car = $this->carService->create($createCarRequest);

        return $this->apiResponse(compact('car'), 201, __('Data has been added successfully'));
    }

    public function update($id, UpdateCarRequest $updateCarRequest)
    {
        $car = $this->carService->update($id, $updateCarRequest);

        return $this->apiResponse(compact('car'), 200, __('Data has been updated successfully'));
    }

    public function destroy($id)
    {
        $this->carService->delete($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }

    public function deleteImage($id, $imageIndex)
    {
        $this->carService->removeImage($id, $imageIndex);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
