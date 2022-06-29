<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\CommonModule\Transformers\CategoryResource;
use Modules\CommonModule\Transformers\WalkThroughImageResource;

class InitService
{
    private $settings;


    public function __construct(SettingService $settingService)
    {
        $this->settings = $settingService->getSettings();
    }


    public function initData(Request $request)
    {
        $walkThroughImages = [];

        if ($this->settings->walk_through_images && is_array($this->settings->walk_through_images)) {
            $walkThroughImages = WalkThroughImageResource::collection($this->settings->walk_through_images);
        }

        return [
            'home_main_theme'       => imageUrl($this->settings->home_main_theme),
            'walk_through_images'   => $walkThroughImages,
            'time_interval_user_accept_min' => $this->settings->time_interval_user_accept_min,
            'time_interval_vendor_accept_min' => $this->settings->time_interval_vendor_accept_min,
            'booking_running'       => [],
            'categories'            => CategoryResource::collection($this->settings->categories),
            'need_update'           => $this->appNeedUpdated($request->version, $request->platform),
            'force_updated'         => $this->getForceUpdated($request->platform),
            'force_updated_link'    => $this->getForceUpdatedLink($request->platform),
            'default_country'       => $this->settings->default_country,
            'default_city'          => $this->settings->default_city,
            'push_version'          => 17
        ];
    }


    private function appNeedUpdated($userVersion, $platform)
    {
        $currentVersion = ['android' => $this->settings->android_app_version, 'ios' => $this->settings->ios_app_version][$platform];

        if (!$currentVersion) {
            Log::alert('something error when get current app version');
        }

        return ($currentVersion != $userVersion);
    }


    private function getForceUpdated($platform)
    {
        $platform = $platform . '_force_updated';
        return (bool)$this->settings->{$platform};
    }


    private function getForceUpdatedLink($platform)
    {
        $platform = $platform . '_force_updated_link';
        return $this->settings->{$platform};
    }
}
