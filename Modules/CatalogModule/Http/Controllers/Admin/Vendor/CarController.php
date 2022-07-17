<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateCarRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateCarRequest;
use Modules\CatalogModule\Services\Admin\CarService;
use Modules\CommonModule\Traits\ApiResponseTrait;

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
        $result = $this->carService->create($createCarRequest);

        return $this->apiResponse(...$result);
    }

    public function update($id, UpdateCarRequest $updateCarRequest)
    {
        $result = $this->carService->update($id, $updateCarRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($id)
    {
        $result = $this->carService->delete($id);

        return $this->apiResponse(...$result);
    }

    public function deleteImage($id, $imageIndex)
    {
        $result = $this->carService->removeImage($id, $imageIndex);

        return $this->apiResponse(...$result);
    }
}
