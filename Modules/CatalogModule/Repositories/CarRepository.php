<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Enums\EntityType;
use MongoDB\BSON\ObjectId;

class CarRepository
{
    use EntityHelperRepository;

    public function __construct(Car $model)
    {
        $this->model = $model;
    }

    public function listOfCars(Request $request)
    {
        return $this->model->search($request)
                           ->with(['model', 'brand', 'country'])
                           ->whereHas('model', function ($query) { $query->active(); })
                           ->whereHas('brand', function ($query) { $query->active(); })
                           ->filter($request, EntityType::CAR)
                           ->filterDate($request)
                           ->active()
                           ->available()
                           ->free()
                           ->latest()
                           ->paginate($request->get('limit', 20));
    }


    public function findCarWithDetailsById($carId)
    {
        return $this->model->with(['model', 'brand'])->findOrFail($carId);
    }


    public function findAllByVendor(Request $request, $vendorId)
    {
        return $this->model->adminSearch($request)
                            ->with(['model', 'brand'])
                            ->adminFilter($request, EntityType::CAR)
                            ->latest()
                            ->where('vendor_id', new ObjectId($vendorId))
                            ->paginate($request->get('limit', 20));
    }
}
