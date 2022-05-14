<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Modules\CommonModule\Repositories\CityRepository;
use Modules\CommonModule\Repositories\CountryRepository;
use Modules\CommonModule\Repositories\StartUpImageRepository;
use Modules\CommonModule\Transformers\CityResource;
use Modules\CommonModule\Transformers\CountryResource;
use Modules\CommonModule\Transformers\StartUpImageResource;

class CommonService
{
    public function countries(Request $request)
    {
        $countries = app(CountryRepository::class)->list($request);

        return CountryResource::collection($countries);
    }

    public function cities(Request $request)
    {
        $cities = app(CityRepository::class)->list($request);

        return CityResource::collection($cities);
    }

    public function getStartUpImages(Request $request)
    {
        $startUpImages = app(StartUpImageRepository::class)->list($request->get('limit'));

        return StartUpImageResource::collection($startUpImages);
    }
}
