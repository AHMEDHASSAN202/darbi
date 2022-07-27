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

        return successResponse(['places' => SavedPlaceResource::collection($this->savedUserRepository->listPlacesByUserId($userId))]);
    }

    public function createPlace(CreatePlaceRequest $createPlaceRequest)
    {
        //get location
        $location = (new Proxy(new AuthProxy('GET_LOCATION', ['lat' => $createPlaceRequest->lat, 'lng' => $createPlaceRequest->lng])))->result();

        if (!$location) {
            return badResponse([], __('Location not found!'));
        }

        try {

            $created = $this->savedUserRepository->create([
                'user_id'       => new ObjectId(auth('api')->id()),
                'lat'           => $createPlaceRequest->lat,
                'lng'           => $createPlaceRequest->lng,
                'country'       => $location['country'],
                'city'          => $location['city'],
                'full_address'  => $location['fully_addressed']
            ]);

            return successResponse(new SavedPlaceResource($created), __('Successful created place'));

        } catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serverErrorResponse();
        }
    }
}
