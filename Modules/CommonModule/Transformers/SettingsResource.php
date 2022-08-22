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
    public function toArray($request)
    {
        return [
            'time_interval_vendor_accept_min'           => (int)$this->time_interval_vendor_accept_min,
            'time_interval_user_accept_min'             => (int)$this->time_interval_user_accept_min,
            'time_reminder_before_picked_up'            => (int)$this->time_reminder_before_picked_up,
            'time_reminder_before_dropped'              => (int)$this->time_reminder_before_dropped,
            'walk_through_images'                       => $this->getWalkThroughImages(),
            'categories'                                => CategoryResource::collection($this->categories),
            'home_main_theme'                           => imageUrl($this->home_main_themem, 'original'),
            'android_app_version'                       => (float)$this->android_app_version,
            'android_force_updated'                     => (boolean)$this->android_force_updated,
            'android_force_updated_link'                => $this->android_force_updated_link,
            'ios_app_version'                           => (float)$this->ios_app_version,
            'ios_force_updated'                         => (boolean)$this->ios_force_updated,
            'ios_force_updated_link'                    => $this->ios_force_updated_link,
            'default_country'                           => $this->default_country,
            'default_city'                              => $this->default_city,
            'darbi_percentage'                          => (int)$this->darbi_percentage,
            'private_jets_images'                       => isset($this->private_jets_info['images']) ? array_map(function ($image) { return imageUrl($image,'original'); }, $this->private_jets_info['images']) : [],
            'private_jets_title'                        => $this->private_jets_info['title'],
            'private_jets_desc'                         => $this->private_jets_info['desc'],
            'private_jets_phone'                        => $this->private_jets_info['phone'],
            'private_jets_whatsapp'                     => $this->private_jets_info['whatsapp'],
            'private_jets_email'                        => $this->private_jets_info['email']
        ];
    }


    private function getWalkThroughImages()
    {
        $walk_through_images = $this->walk_through_images ?? [];

        return array_map(
            function ($walkThrough) {
                $walkThrough['image'] = isset($walkThrough['image']) ? imageUrl($walkThrough['image'], 'original') : '';
                return $walkThrough;
            },
            $walk_through_images
        );
    }
}
