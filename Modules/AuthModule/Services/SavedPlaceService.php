<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;


use Illuminate\Support\Facades\Log;
use Modules\AuthModule\Entities\User;
use Modules\AuthModule\Http\Requests\CreatePlaceRequest;
use Modules\AuthModule\Repositories\User\SavedUserRepository;
use Modules\AuthModule\Transformers\SavedPlaceResource;
use Modules\CommonModule\Services\RegionService;

class SavedPlaceService
{
    private $savedUserRepository;

    public function __construct(SavedUserRepository $savedUserRepository)
    {
        $this->savedUserRepository = $savedUserRepository;
    }

    public function getUserPlaces()
    {
        $userId = auth('api')->id() ?? User::first()->id;

        return SavedPlaceResource::collection($this->savedUserRepository->listPlacesByUserId($userId));
    }

    public function createPlace(CreatePlaceRequest $createPlaceRequest)
    {
        $result['responseData'] = [];
        $result['statusCode'] = 200;
        $result['message'] = '';

        $region = app(RegionService::class)->findRegionByLatAndLngWithCountryAndCity($createPlaceRequest->lat, $createPlaceRequest->lng);

        if (!$region) {
            $result['message'] = __('region not found!');
            $result['statusCode'] = 400;
            return $result;
        }

        try {

            $created = $this->savedUserRepository->create([
                'user_id'       => auth('api')->user()->_id,
                'lat'           => $createPlaceRequest->lat,
                'lng'           => $createPlaceRequest->lng,
                'country'       => translateAttribute(optional($region->country)->name),
                'city'          => translateAttribute(optional($region->city)->name),
                'region_id'     => $region->_id
            ]);

            $result['responseData'] = new SavedPlaceResource($created);
            $result['message'] = __('Successful created place');

        }catch (\Exception $exception) {
            $result['message'] = __('something error!');
            $result['statusCode'] = 500;
            Log::error('createPlace: ' . $exception->getMessage());
        }

        return $result;
    }
}
