<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;


use Modules\AuthModule\Entities\SavedPlace;
use Modules\AuthModule\Entities\User;
use Modules\AuthModule\Repositories\User\SavedUserRepository;
use Modules\AuthModule\Transformers\SavedPlaceResource;

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
}
