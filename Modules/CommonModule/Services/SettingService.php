<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
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

        $walkThroughImages = $this->getSettings()->walk_through_images ?? [];

        if (!empty($data['walk_through_images'])) {
            foreach ($data['walk_through_images'] as $key => $walkThroughImage) {
                $walkThroughImages[$key] = [
                    'title' => $walkThroughImage['title'],
                    'desc'  => $walkThroughImage['desc'],
                    'image' => $walkThroughImages[$key]['image'] ?? ""
                ];

                if (isset($walkThroughImage['image']) && $walkThroughImage['image'] instanceof UploadedFile) {
                    $walkThroughImages[$key]['image'] = $this->uploadImage('walk_through_images', $walkThroughImage['image'], []);
                }
            }
        }
        $data['walk_through_images'] = $walkThroughImages;

        $this->settingRepository->updateSettings($data);

        $this->clearSettingsCache();

        return successResponse([]);
    }


    public function removeWalkThroughImage($index)
    {
        $walkThroughImages = $this->getSettings()->walk_through_images;

        if (!isset($walkThroughImages[$index])) {
            return badResponse([], __('Walk through is not exists'));
        }

        unset($walkThroughImages[$index]);

        $this->settingRepository->updateSettings(['walk_through_images' => $walkThroughImages]);

        $this->clearSettingsCache();

        return successResponse([]);
    }
}
