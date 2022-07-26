<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($setting)
    {
        return [
            'time_interval_vendor_accept_min'           => $setting->time_interval_vendor_accept_min,
            'time_interval_user_accept_min'             => $setting->time_interval_user_accept_min,
            'walk_through_images'                       => WalkThroughImageResource::collection($setting->walk_through_images),
            'categories'                                => CategoryResource::collection($this->categories),
            'home_main_theme'                           => imageUrl($setting->home_main_themem, 'original'),
            'android_app_version'                       => $setting->android_app_version,
            'android_force_updated'                     => $setting->android_force_updated,
            'android_force_updated_link'                => $setting->android_force_updated_link,
            'ios_app_version'                           => $setting->ios_app_version,
            'ios_force_updated'                         => $setting->ios_force_updated,
            'ios_force_updated_link'                    => $setting->ios_force_updated_link,
            'default_country'                           => $setting->default_country,
            'default_city'                              => $setting->default_city,
            'darbi_percentage'                          => $setting->darbi_percentage,
        ];
    }
}
