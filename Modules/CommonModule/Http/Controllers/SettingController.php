<?php

namespace Modules\CommonModule\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\UpdateSettingRequest;
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
        return $this->apiResponse([
            'settings' => $this->settingService->getSettings()
        ]);
    }

    public function update(Request $request)
    {
        $settings = $this->settingService->updateSetting($request);

        return $this->apiResponse(compact('settings'), 200, __('Data has been updated successfully'));
    }
}
