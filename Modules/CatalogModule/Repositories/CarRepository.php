<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Car;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class CarRepository
{
    use CrudRepositoryTrait;

    public function __construct(Car $model)
    {
        $this->model = $model;
    }

    public function listOfCars(Request $request)
    {
        return $this->model->search($request)
                           ->with(['model', 'brand'])
                           ->whereHas('model', function ($query) { $query->active(); })
                           ->whereHas('brand', function ($query) { $query->active(); })
                           ->when($request->region, function ($query) use ($request) {
                               $branchIds = app(BranchesRepository::class)->findAllBranchesByRegion($request->region, true)->pluck('_id')->toArray();
                               $query->where('branch_ids', 'all', $branchIds);
                           })
                           ->filter($request)
                           ->filterDate($request)
                           ->active()
                           ->available()
                           ->free()
                           ->latest()
                           ->paginate($request->get('limit', 20));
    }


    public function findCarWithDetailsById($carId)
    {
        return $this->model->with(['model', 'brand', 'plugins' => function ($query) { $query->active(); }])->findOrFail($carId);
    }


    public function findAllByVendor(Request $request, $vendorId)
    {
        return $this->model->adminSearch($request)
                            ->with(['model', 'brand'])
                            ->adminFilter($request)
                            ->latest()
                            ->where('vendor_id', new ObjectId($vendorId))
                            ->paginate($request->get('limit', 20));
    }


    public function findByVendor($vendorId, $carId)
    {
        return $this->model->with(['model', 'brand'])->where('vendor_id', new ObjectId($vendorId))->findOrFail($carId);
    }
}
