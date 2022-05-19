<?php

namespace Modules\AuthModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
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
        return $this->apiResponse([
            'places'    => $this->savedPlaceService->getUserPlaces()
        ]);
    }
}
