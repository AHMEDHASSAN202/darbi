<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Villa;
use Modules\CatalogModule\Enums\EntityType;
use MongoDB\BSON\ObjectId;

class VillaRepository
{
    use EntityHelperRepository;

    public function __construct(Villa $model)
    {
        $this->model = $model;
    }

    public function listOfVillas(Request $request)
    {
        return $this->model->search($request)
                           ->filter($request, EntityType::VILLA)
                           ->filterDate($request)
                           ->active()
                           ->available()
                           ->whereHas('vendor', function ($query) { $query->active(); })
                           ->latest()
                           ->paginated();
    }


    public function findVillaWithDetailsById($villaId)
    {
        return $this->model->whereHas('vendor', function ($query) { $query->active(); })->find($villaId);
    }

    public function findAllByVendor(Request $request, $vendorId)
    {
        return $this->model->adminSearch($request)
                            ->with([
                                'vendor' => function ($q) { $q->withTrashed(); },
                                'city'   => function ($q) { $q->withTrashed(); }
                            ])
                            ->adminFilter($request, EntityType::VILLA)
                            ->latest()
                            ->where('vendor_id', new ObjectId($vendorId))
                            ->paginated();
    }

    public function findAll(Request $request)
    {
        return $this->model->adminSearch($request)
                            ->with([
                                'vendor' => function ($q) { $q->withTrashed(); }
                            ])
                            ->adminFilter($request, EntityType::VILLA)
                            ->latest()
                            ->paginated();
    }
}
