<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Http\Requests\AddBranchToRegionsRequest;
use Modules\CommonModule\Http\Requests\CreateRegionRequest;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;
use Modules\CommonModule\Http\Requests\RemoveBranchFromRegionsRequest;
use Modules\CommonModule\Http\Requests\UpdateRegionRequest;
use Modules\CommonModule\Repositories\RegionRepository;
use Modules\CommonModule\Transformers\FindRegionResource;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\CommonModule\Transformers\RegionResource;
use MongoDB\BSON\ObjectId;

class RegionService
{
    private $regionRepository;

    public function __construct()
    {
        $this->regionRepository = new RegionRepository();
    }

    public function regions(Request $request)
    {
        $regions = $this->regionRepository->listOfRegions($request);

        if ($regions instanceof LengthAwarePaginator) {
            return successResponse(['regions' => new PaginateResource(RegionResource::collection($regions))]);
        }

        return successResponse(['regions' => RegionResource::collection($regions)]);
    }

    public function findRegionsByNorthEastAndSouthWest(GetRegionsByNorthEastAndSouthWestRequest $getRegionsByNorthEastAndSouthWest)
    {
        $mapBounds = $getRegionsByNorthEastAndSouthWest->mapBounds;

        $coordinates = [
            [(float)$mapBounds['northEast']['lng'], (float)$mapBounds['northEast']['lat']],
            [(float)$mapBounds['northEast']['lng'], (float)$mapBounds['southWest']['lat']],
            [(float)$mapBounds['southWest']['lng'], (float)$mapBounds['southWest']['lat']],
            [(float)$mapBounds['southWest']['lng'], (float)$mapBounds['northEast']['lat']],
            [(float)$mapBounds['northEast']['lng'], (float)$mapBounds['northEast']['lat']],
        ];

        $regions = $this->regionRepository->findRegionsByNorthEastAndSouthWest($coordinates);

        return RegionResource::collection($regions);
    }

    public function findRegionByLatAndLng($lat, $lng, $branchId = null)
    {
        return $this->regionRepository->findRegionByLatAndLng($lat, $lng, $branchId);
    }

    public function regionsByVendor($request)
    {
        $regions = $this->regionRepository->listByVendor(getVendorId(), $request);

        if ($regions instanceof LengthAwarePaginator) {
            return successResponse(['regions' => new PaginateResource(RegionResource::collection($regions))]);
        }

        return successResponse(['regions' => RegionResource::collection($regions)]);
    }

    public function regionByVendor($id)
    {
        $region = $this->regionRepository->findOne($id, false, getVendorId());

        return successResponse(['region' => new FindRegionResource($region)]);
    }

    public function create(CreateRegionRequest $createRegionRequest)
    {
        try {
            $region = $this->regionRepository->create([
                'vendor_id' => new ObjectId(getVendorId()),
                'name'      => $createRegionRequest->name,
                'is_active' => ($createRegionRequest->is_active === null) || (boolean)$createRegionRequest->is_active,
                'location'  => [
                    'type'          => 'Polygon',
                    'coordinates'   => [$this->prepareLocationPoints($createRegionRequest->location)]
                ]
            ]);

            return createdResponse(['id' => $region->id]);

        }catch (\Exception $exception) {
            return badResponse([], __("Can't extract geo keys"));
        }
    }

    public function update($id, UpdateRegionRequest $updateRegionRequest)
    {
        $region = $this->regionRepository->updateByVendor($id, [
            'name'      => $updateRegionRequest->name,
            'is_active' => ($updateRegionRequest->is_active === null) || (boolean)$updateRegionRequest->is_active,
            'location'  => [
                'type'          => 'Polygon',
                'coordinates'   => [$this->prepareLocationPoints($updateRegionRequest->location)]
            ]
        ], getVendorId());

        return updatedResponse(['id' => $region->id]);
    }

    public function destroy($id)
    {
        $this->regionRepository->destroyByVendor($id, getVendorId());

        return deletedResponse([]);
    }

    private function prepareLocationPoints($locations)
    {
        if (empty($locations) || !is_array($locations)) {
            return [];
        }

        $points = array_map(function ($location) { return [$location['lng'], $location['lat']]; }, $locations);

        if ($points[0] != end($points)) {
            $points[] = $points[0];
        }

        return $points;
    }

    public function addBranchToRegions(AddBranchToRegionsRequest $addBranchToRegionsRequest)
    {
        $this->regionRepository->addBranchToRegions($addBranchToRegionsRequest);

        return successResponse();
    }

    public function removeBranchFromRegions(RemoveBranchFromRegionsRequest $removeBranchFromRegionsRequest)
    {
        $this->regionRepository->removeBranchFromRegions($removeBranchFromRegionsRequest);

        return successResponse();
    }
}
