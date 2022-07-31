<?php

namespace Modules\CommonModule\Http\Controllers\Admin;


use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\UpdateSettingsRequest;
use Modules\CommonModule\Services\SettingService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class SettingController extends Controller
{
    use ApiResponseTrait;

    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $result = $this->settingService->index();

        return $this->apiResponse(...$result);
    }

    public function update(UpdateSettingsRequest $updateSettingsRequest)
    {
        $result = $this->settingService->update($updateSettingsRequest);

        return $this->apiResponse(...$result);
    }

    public function clearSettingCache()
    {
        $this->settingService->clearSettingsCache();

        return $this->apiResponse([]);
    }
}
