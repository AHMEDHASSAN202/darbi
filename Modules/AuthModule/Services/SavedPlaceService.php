<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use App\Proxy\Proxy;
use Illuminate\Support\Facades\Log;
use Modules\AuthModule\Http\Requests\CreatePlaceRequest;
use Modules\AuthModule\Proxy\AuthProxy;
use Modules\AuthModule\Repositories\User\SavedUserRepository;
use Modules\AuthModule\Transformers\SavedPlaceResource;
use MongoDB\BSON\ObjectId;

class SavedPlaceService
{
    private $savedUserRepository;

    public function __construct(SavedUserRepository $savedUserRepository)
    {
        $this->savedUserRepository = $savedUserRepository;
    }

    public function getUserPlaces()
    {
        $userId = auth('api')->id();

        return SavedPlaceResource::collection($this->savedUserRepository->listPlacesByUserId($userId));
    }

    public function createPlace(CreatePlaceRequest $createPlaceRequest)
    {
        $result['responseData'] = [];
        $result['statusCode'] = 200;
        $result['message'] = '';

        //get location
        $location = (new Proxy(new AuthProxy('GET_LOCATION', ['lat' => $createPlaceRequest->lat, 'lng' => $createPlaceRequest->lng])))->result();
        $region = (new Proxy(new AuthProxy('GET_REGION', ['lat' => $createPlaceRequest->lat, 'lng' => $createPlaceRequest->lng])))->result();

        if (!$location) {
            $result['message'] = __('location not found!');
            $result['statusCode'] = 400;
            return $result;
        }

        if (!$region) {
            $result['message'] = __('region not supported!');
            $result['statusCode'] = 400;
            return $result;
        }

        try {

            $created = $this->savedUserRepository->create([
                'user_id'       => auth('api')->user()->_id,
                'lat'           => $createPlaceRequest->lat,
                'lng'           => $createPlaceRequest->lng,
                'country'       => $location->country,
                'city'          => $location->city,
                'full_address'  => $location->fully_addressed,
                'region_id'     => new ObjectId($region->id)
            ]);

            $result['responseData'] = new SavedPlaceResource($created);
            $result['message'] = __('Successful created place');

        } catch (\Exception $exception) {
            $result['message'] = __('something error!');
            $result['statusCode'] = 500;
            Log::error('createPlace: ' . $exception->getMessage());
        }

        return $result;
    }
}
