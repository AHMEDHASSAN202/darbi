<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Modules\CommonModule\Entities\Setting;

class SettingRepository
{
    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function getSettings()
    {
        return $this->model->first();
    }

    public function updateSettings($data)
    {
        $settings = $this->getSettings();

        if (isset($data['time_interval_vendor_accept_min'])) {
            $settings->time_interval_vendor_accept_min = (int)$data['time_interval_vendor_accept_min'];
        }

        if (isset($data['time_interval_user_accept_min'])) {
            $settings->time_interval_user_accept_min = (int)$data['time_interval_user_accept_min'];
        }

        if (isset($data['time_reminder_before_picked_up'])) {
            $settings->time_reminder_before_picked_up = (int)$data['time_reminder_before_picked_up'];
        }

        if (isset($data['time_reminder_before_dropped'])) {
            $settings->time_reminder_before_dropped = (int)$data['time_reminder_before_dropped'];
        }

        if (isset($data['walk_through_images']) && !empty($data['walk_through_images'])) {
            $settings->walk_through_images = $data['walk_through_images'];
        }

        if (isset($data['home_main_theme'])) {
            $settings->home_main_theme = $data['home_main_theme'];
        }

        if (isset($data['android_app_version'])) {
            $settings->android_app_version = (float)$data['android_app_version'];
        }

        if (isset($data['android_force_updated'])) {
            $settings->android_force_updated = (boolean)$data['android_force_updated'];
        }

        if (isset($data['android_force_updated_link'])) {
            $settings->android_force_updated_link = $data['android_force_updated_link'];
        }

        if (isset($data['ios_app_version'])) {
            $settings->ios_app_version = (float)$data['ios_app_version'];
        }

        if (isset($data['ios_force_updated'])) {
            $settings->ios_force_updated = (boolean)$data['ios_force_updated'];
        }

        if (isset($data['ios_force_updated_link'])) {
            $settings->ios_force_updated_link = $data['ios_force_updated_link'];
        }

        if (isset($data['default_country'])) {
            $settings->default_country = $data['default_country'];
        }

        if (isset($data['default_city'])) {
            $settings->default_city = $data['default_city'];
        }

        if (isset($data['darbi_percentage'])) {
            $settings->darbi_percentage = (int)$data['darbi_percentage'];
        }

        $privateJetInfo = $settings->private_jets_info ?? [];

        if (isset($data['private_jets_images'])) {
            $privateJetInfo['images'] = $data['private_jets_images'];
        }

        if (isset($data['private_jets_title'])) {
            $privateJetInfo['title'] = $data['private_jets_title'];
        }

        if (isset($data['private_jets_desc'])) {
            $privateJetInfo['desc'] = $data['private_jets_desc'];
        }

        if (isset($data['private_jets_phone'])) {
            $privateJetInfo['phone'] = $data['private_jets_phone'];
        }

        if (isset($data['private_jets_whatsapp'])) {
            $privateJetInfo['whatsapp'] = $data['private_jets_whatsapp'];
        }

        if (isset($data['private_jets_email'])) {
            $privateJetInfo['email'] = $data['private_jets_email'];
        }

        $settings->private_jets_info = $privateJetInfo;

        return $settings->save();
    }
}
