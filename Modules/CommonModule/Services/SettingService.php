<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Support\Facades\Cache;
use Modules\CommonModule\Entities\Setting;

class SettingService
{
    public function getSettings()
    {
        return Cache::rememberForever('settings', function () {
            return Setting::first();
        });
    }

    public function clearSettingsCache()
    {
        return Cache::forget('settings');
    }
}
