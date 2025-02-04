<?php

namespace Modules\AuthModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\CreatePlaceRequest;
use Modules\AuthModule\Services\SavedPlaceService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class SavedPlaceController extends Controller
{
    use ApiResponseTrait;

    private $savedPlaceService;

    public function __construct(SavedPlaceService $savedPlaceService)
    {
        $this->savedPlaceService = $savedPlaceService;
    }

    public function findAll()
    {
        $result = $this->savedPlaceService->getUserPlaces();

        return $this->apiResponse(...$result);
    }

    public function store(CreatePlaceRequest $createPlaceRequest)
    {
        $result = $this->savedPlaceService->createPlace($createPlaceRequest);

        return $this->apiResponse(...$result);
    }
}
