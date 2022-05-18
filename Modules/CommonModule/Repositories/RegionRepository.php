<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Entities\Region;
use Modules\CommonModule\Http\Requests\GetRegionByLatAndLngRequest;

class RegionRepository
{
    private $model;

    public function __construct(Region $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        $query = $this->model->active()->search($request)->filter($request);

        if ($embedParam = $request->get('embed')) {

            $embeds = explode(',', $embedParam);
            $with = [];

            foreach ($embeds as $embed) {
                switch ($embed) {
                    case 'country':
                        $with[] = 'country';
                        break;
                    case 'city':
                        $with[] = 'city';
                        break;
                }
            }

            $query->with($with);
        }

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }

    public function findRegionByLatAndLng(GetRegionByLatAndLngRequest $getRegionByLatAndLngRequest)
    {
        return Region::where('location', 'geoIntersects', [
                    '$geometry' => [
                        'type' => 'Point',
                        'coordinates' => [(float)$getRegionByLatAndLngRequest->lat, (float)$getRegionByLatAndLngRequest->lng],
                    ],
                ])->first();
    }
}
