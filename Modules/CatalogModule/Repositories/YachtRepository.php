<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Yacht;
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
                           ->filter($request)
                           ->filterDate($request)
                           ->active()
                           ->available()
                           ->free()
                           ->with(['model', 'country'])
                           ->whereHas('port', function ($query) { $query->active(); })
                           ->latest()
                           ->paginate($request->get('limit', 20));
    }


    public function findYachtWithDetailsById($yachtId)
    {
        return $this->model->with(['model', 'port'])->find($yachtId);
    }

    public function findAllByVendor(Request $request, $vendorId)
    {
        return $this->model->adminSearch($request)
                            ->with(['port'])
                            ->adminFilter($request)
                            ->latest()
                            ->where('vendor_id', new ObjectId($vendorId))
                            ->paginate($request->get('limit', 20));
    }
}
