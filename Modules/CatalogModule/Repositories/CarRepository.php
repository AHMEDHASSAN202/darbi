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
                           ->whereHas('model', function ($query) { $query->active(); })
                           ->whereHas('brand', function ($query) { $query->active(); })
                           ->whereHas('branch', function ($query) { $query->active(); })
                           ->whereHas('vendor', function ($query) { $query->active(); })
                           ->filter($request, EntityType::CAR)
                           ->filterDate($request)
                           ->active()
                           ->available()
                           ->latest()
                           ->paginated();
    }


    public function findCarWithDetailsById($carId)
    {
        return $this->model->with(['model' => function ($q) { $q->withTrashed(); }, 'brand' => function ($q) { $q->withTrashed(); }, 'car_type'])->whereHas('branch', function ($query) { $query->active(); })->whereHas('vendor', function ($query) { $query->active(); })->findOrFail($carId);
    }


    public function findAllByVendor(Request $request, $vendorId)
    {
        return $this->model->adminSearch($request)
                            ->with([
                                'model' => function ($q) { $q->withTrashed(); },
                                'brand' => function ($q) { $q->withTrashed(); },
                                'vendor' => function ($q) { $q->withTrashed(); },
                                'branch' => function ($q) { $q->withTrashed(); }
                            ])
                            ->adminFilter($request, EntityType::CAR)
                            ->latest()
                            ->where('vendor_id', new ObjectId($vendorId))
                            ->paginated();
    }


    public function findAll(Request $request)
    {
        return $this->model->adminSearch($request)
                            ->with([
                                'model' => function ($q) { $q->withTrashed(); },
                                'brand' => function ($q) { $q->withTrashed(); },
                                'vendor' => function ($q) { $q->withTrashed(); },
                                'branch' => function ($q) { $q->withTrashed(); }
                            ])
                            ->adminFilter($request, EntityType::CAR)
                            ->latest()
                            ->paginated();
    }
}
