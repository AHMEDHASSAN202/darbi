<?php

namespace Modules\CommonModule\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\UpdateSettingRequest;
use Modules\CommonModule\Services\SettingService;
use Modules\CommonModule\Traits\ApiResponseTrait;

/**
 * @group
 *
 * Management Settings System
 */
class SettingController extends Controller
{
    use ApiResponseTrait;

    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Get all settings with groups
     *
     * get settings. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function index()
    {
        return $this->apiResponse([
            'settings' => $this->settingService->getSettings()
        ]);
    }

    /**
     * Update option
     *
     * @bodyParam option key as name and new value as value
     * If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function update(Request $request)
    {
        $settings = $this->settingService->updateSetting($request);

        return $this->apiResponse(compact('settings'), 200, __('Data has been updated successfully'));
    }
}
