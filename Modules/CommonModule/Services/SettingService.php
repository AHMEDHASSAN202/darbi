<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Modules\CommonModule\Entities\Setting;
use Modules\CommonModule\Http\Requests\UpdateSettingsRequest;
use Modules\CommonModule\Repositories\SettingRepository;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\SettingsResource;

class SettingService
{
    use ImageHelperTrait;

    private $settingRepository;


    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getSettings()
    {
        return Cache::rememberForever('settings', function () {
            return $this->settingRepository->getSettings();
        });
    }

    public function clearSettingsCache()
    {
        return Cache::forget('settings');
    }

    public function index()
    {
        $settings = $this->getSettings();

        return successResponse(['settings' => new SettingsResource($settings)]);
    }

    public function update(UpdateSettingsRequest $updateSettingsRequest)
    {
        $data = $updateSettingsRequest->all();

        if (isset($data['home_main_theme']) && $data['home_main_theme'] instanceof UploadedFile) {
            $data['home_main_theme'] = $this->uploadImage('settings', $data['home_main_theme'], []);
        }

        $walkThroughImages = [];
        if (!empty($data['walk_through_images'])) {
            foreach ($data['walk_through_images'] as $walkThroughImage) {
                if (isset($walkThroughImage['image']) && $walkThroughImage['image'] instanceof UploadedFile) {
                    $walkThroughImages[] = [
                        'title' => $walkThroughImage['title'],
                        'desc'  => $walkThroughImage['desc'],
                        'image' => $this->uploadImage('walk_through_images', $walkThroughImage['image'], [])
                    ];
                }
            }
        }
        $data['walk_through_images'] = $walkThroughImages;

        $this->settingRepository->updateSettings($data);

        $this->clearSettingsCache();

        return successResponse([]);
    }
}
