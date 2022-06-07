<?php

namespace Modules\CommonModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CommonModule\Entities\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'time_interval_vendor_accept_min'       => 22,
            'time_interval_user_accept_min'         => 22,
            'walk_through_images'                   => [
                ['title' => ['ar' => 'هذا النص هو مثال', 'en' => 'Lorem Ipsum'], 'desc' => ['ar' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى', 'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'], 'image' => 'https://via.placeholder.com/300x600'],
                ['title' => ['ar' => 'هذا النص هو مثال', 'en' => 'Lorem Ipsum'], 'desc' => ['ar' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى', 'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'], 'image' => 'https://via.placeholder.com/300x600']
            ],
            'categories'                            => [
                ['name' => ['ar' => 'سيارات', 'en' => 'Exotics'], 'desc' => ['ar' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى', 'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'], 'image' => 'https://via.placeholder.com/300x600', 'template' => 0],
                ['name' => ['ar' => 'اليخوت', 'en' => 'Yachts'], 'desc' => ['ar' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى', 'en' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'], 'image' => 'https://via.placeholder.com/300x600', 'template' => 1],
            ],
            'home_main_theme'                       => 'https://via.placeholder.com/400x300',
            'specs_keys'                            => ['engine_type'],
            'android_app_version'                   => '1.0',
            'ios_app_version'                       => '1.0',
            'default_country'                       => 'AE',
            'default_city'                          => 'DU',
        ];

        Setting::create($settings);
    }
}
