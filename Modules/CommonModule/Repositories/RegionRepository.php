<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Entities\Region;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;

class RegionRepository
{
    private $model;

    public function __construct(Region $model)
    {
        $this->model = $model;
    }


    public function list(Request $request)
    {
        $query = $this->model->active()->search($request)->filter($request)
                             ->when(hasEmbed('country'), function ($q) { $q->with('country'); })
                             ->when(hasEmbed('city'), function ($q) { $q->with('city'); });

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }


    public function findRegionsByNorthEastAndSouthWest($coordinates)
    {
        return $this->model->where('location', 'geoIntersects', [
                                '$geometry' => [
                                    'type'          => 'Polygon',
                                    'coordinates'   => [$coordinates],
                                ],
                            ])
                            ->when(hasEmbed('country'), function ($q) { $q->with('country'); })
                            ->when(hasEmbed('city'), function ($q) { $q->with('city'); })
                            ->active()
                            ->get();
    }


    public function findRegionByLatAndLngWithCountryAndCity($lat, $lng)
    {
        return $this->_findRegionByLatLng($lat, $lng, ['country', 'city']);
    }


    public function findRegionByLatAndLng($lat, $lng)
    {
        return $this->_findRegionByLatLng($lat, $lng);
    }


    private function _findRegionByLatLng($lat, $lng, $with = [])
    {
        return $this->model->active()->where('location', 'near', [
                        '$geometry' => [
                            'type' => 'Point',
                            'coordinates' => [(float)$lng, (float)$lat],
                        ],
                    ])->with($with)->first();
    }
}
