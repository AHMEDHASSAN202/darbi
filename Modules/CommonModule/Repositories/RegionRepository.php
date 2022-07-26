<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Entities\Region;
use Modules\CommonModule\Http\Requests\AddBranchToRegionsRequest;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;
use Modules\CommonModule\Http\Requests\RemoveBranchFromRegionsRequest;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class RegionRepository
{
    private $model;

    use CrudRepositoryTrait;

    public function __construct()
    {
        $this->model = new Region();
    }


    public function listOfRegions(Request $request)
    {
        return $this->model->search($request)->filter($request)->active()->paginated();
    }


    public function findRegionsByNorthEastAndSouthWest($coordinates)
    {
        return $this->model->where('location', 'geoIntersects', [
                                '$geometry' => [
                                    'type'          => 'Polygon',
                                    'coordinates'   => [$coordinates],
                                ],
                            ])
                            ->active()
                            ->get();
    }


    public function findRegionByLatAndLng($lat, $lng, $branchId = null)
    {
        return $this->_findRegionByLatLng($lat, $lng, $branchId);
    }


    private function _findRegionByLatLng($lat, $lng, $branchId = null)
    {
        return $this->model
                    ->active()
                    ->where('location', 'geoIntersects', [
                        '$geometry' => [
                            'type' => 'Point',
                            'coordinates' => [(float)$lng, (float)$lat],
                        ],
                    ])
                    ->when($branchId, function ($query) use ($branchId) {
                        $query->where('branches_ids', new ObjectId($branchId));
                    })
                    ->first();
    }


    public function listByVendor($vendorId, Request $request)
    {
        return $this->model->where('vendor_id', new ObjectId($vendorId))->search($request)->filter($request)->latest()->paginated();
    }

    public function findOne($id, $activeOnly = false, $vendorId = null)
    {
        return $this->model->when($activeOnly, function ($query) { $query->active(); })->when($vendorId, function ($query) use ($vendorId) { $query->where('vendor_id', new ObjectId($vendorId)); })->findOrFail($id);
    }

    public function updateByVendor($id, $data, $vendorId)
    {
        return $this->update($id, $data, ['vendor_id' => new ObjectId($vendorId)]);
    }

    public function destroyByVendor($id, $vendorId)
    {
        return $this->destroy($id, ['vendor_id' => new ObjectId($vendorId)]);
    }

    public function addBranchToRegions(AddBranchToRegionsRequest $addBranchToRegionsRequest)
    {
        return $this->model->whereIn('_id', generateObjectIdOfArrayValues($addBranchToRegionsRequest->regions_ids))->where('branches_id', '!=', new ObjectId($addBranchToRegionsRequest->branch_id))->push('branches_ids', new ObjectId($addBranchToRegionsRequest->branch_id));
    }

    public function removeBranchFromRegions(RemoveBranchFromRegionsRequest $removeBranchFromRegionsRequest)
    {
        return $this->model->where('branches_ids', '=', new ObjectId($removeBranchFromRegionsRequest->branch_id))->pull('branches_ids', new ObjectId($removeBranchFromRegionsRequest->branch_id));
    }
}
