<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\CommonModule\Entities\Setting;
use Modules\CommonModule\Repositories\CityRepository;
use Modules\CommonModule\Repositories\CountryRepository;
use Modules\CommonModule\Repositories\StartUpImageRepository;
use Modules\CommonModule\Transformers\CityResource;
use Modules\CommonModule\Transformers\CountryResource;
use Modules\CommonModule\Transformers\StartUpImageResource;

class InitService
{
    public function initData(Request $request)
    {
        $setting = app(SettingService::class)->getSettings();

        $walkThroughImages = [];

        if ($setting->walk_through_images && is_array($setting->walk_through_images)) {
            foreach ($setting->walk_through_images as $throughImage) {
                $walkThroughImages[] = [
                    'title' => translateAttribute($throughImage['title']),
                    'image' => imageUrl($throughImage['image']),
                    'desc'  => translateAttribute($throughImage['desc'])
                ];
            }
        }

        return [
            'home_main_theme'       => $setting->home_main_theme ? (filter_var($setting->home_main_theme, FILTER_VALIDATE_URL) ?  $setting->home_main_theme : asset($setting->home_main_theme)) : '',
            'walk_through_images'   => $walkThroughImages,
            'time_interval_user_accept_min' => $setting->time_interval_user_accept_min,
            'need_update'           => $this->checkIfAppNeedUpdated($request->version, $request->platform),
        ];
    }

    private function checkIfAppNeedUpdated($userVersion, $platform)
    {
        $setting = app(SettingService::class)->getSettings();

        $currentVersion = ['android' => $setting->android_app_version, 'ios' => $setting->ios_app_version][$platform];

        if (!$currentVersion) {
            Log::alert('sometimes error when get current app version');
        }

        return ($currentVersion != $userVersion);
    }
}
