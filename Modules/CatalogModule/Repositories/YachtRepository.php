<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Enums\EntityType;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class YachtRepository
{
    use EntityHelperRepository;

    public function __construct(Yacht $model)
    {
        $this->model = $model;
    }

    public function listOfYachts(Request $request)
    {
        return $this->model->search($request)
                           ->filter($request, EntityType::YACHT)
                           ->filterDate($request)
                           ->active()
                           ->available()
                           ->free()
                           ->with(['model' => function ($q) { $q->withTrashed(); }, 'country' => function ($q) { $q->withTrashed(); }])
                           ->whereHas('port', function ($query) { $query->active(); })
                           ->latest()
                           ->paginate($request->get('limit', 20));
    }


    public function findYachtWithDetailsById($yachtId)
    {
        return $this->model->with(['model' => function ($q) { $q->withTrashed(); }, 'port' => function ($q) { $q->withTrashed(); }])->find($yachtId);
    }

    public function findAllByVendor(Request $request, $vendorId)
    {
        return $this->model->adminSearch($request)
                            ->with([
                                'port' => function ($q) { $q->withTrashed(); },
                                'vendor' => function ($q) { $q->withTrashed(); }
                            ])
                            ->adminFilter($request, EntityType::YACHT)
                            ->latest()
                            ->where('vendor_id', new ObjectId($vendorId))
                            ->paginate($request->get('limit', 20));
    }

    public function findAll(Request $request)
    {
        return $this->model->adminSearch($request)
                            ->with([
                                'port' => function ($q) { $q->withTrashed(); },
                                'vendor' => function ($q) { $q->withTrashed(); }
                            ])
                            ->adminFilter($request, EntityType::YACHT)
                            ->latest()
                            ->paginate($request->get('limit', 20));
    }
}
