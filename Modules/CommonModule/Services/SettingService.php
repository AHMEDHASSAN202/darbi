<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Modules\CommonModule\Repositories\SettingRepository;
use Modules\CommonModule\Transformers\SettingResource;

class SettingService
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getSettings()
    {
        return Cache::rememberForever('settings', function () {
            return $this->settingRepository->list()->map(function ($setting) { return new SettingResource($setting); })->groupBy('group');
        });
    }

    public function updateSetting($request)
    {
        $settings = $this->getSettings()->flatten(1);

        foreach ($settings as $setting) {
            if ($value = $request->{$setting->key}) {
                if (in_array($setting->type, ['image', 'file'])) {
                    if ($value instanceof UploadedFile) {
                        $setting->update(['value' => $value->store('settings', 'public')]);
                    }else {
                        continue;
                    }
                }else {
                    $setting->update(['value' => $value]);
                }
            }
        }

        $this->clearCache();

        return $this->getSettings();
    }

    private function clearCache()
    {
        Cache::forget('settings');
    }
}
