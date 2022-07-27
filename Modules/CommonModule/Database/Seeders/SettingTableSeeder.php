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
            'time_interval_vendor_accept_min'       => 22,   //minute
            'time_interval_user_accept_min'         => 22,   //minute
            'time_reminder_before_picked_up'        => 120,  //minute
            'time_reminder_before_dropped'          => 120,  //minute
            'walk_through_images'                   => [
                ['title' => ['ar' => 'رحلة تستحقها', 'en' => 'Trip you deserve'], 'desc' => ['ar' => 'يساعدك داربي في العثور على أفضل السيارات واليخوت لقضاء رحلة استثنائية.', 'en' => 'Darbi helps you to find the best exotics and yachts to have an exceptional trip.'], 'image' => 'https://i.ibb.co/bXcRvgx/intro1.png'],
                ['title' => ['ar' => 'مجموعة واسعة من الخيارات', 'en' => 'Wide range of Choices'], 'desc' => ['ar' => 'يقدم لك داربي مجموعة واسعة من السيارات واليخوت مع خيارات لتخصيص رحلتك.', 'en' => 'Darbi offers you a wide range of exotics & yachts with options to customize your ride.'], 'image' => 'https://i.ibb.co/bXcRvgx/intro1.png']
            ],
            'categories'                            => [
                ['name' => ['ar' => 'سيارات', 'en' => 'Exotics'], 'desc' => ['ar' => 'سيارات فاخرة راقية.', 'en' => 'High-end luxury exotics.'], 'image' => 'https://i.ibb.co/QbpZh9c/cars.png', 'template' => 0],
                ['name' => ['ar' => 'اليخوت', 'en' => 'Yachts'], 'desc' => ['ar' => 'اليخوت الفاخرة لك.', 'en' => 'Premium yachts for you.'], 'image' => 'https://i.ibb.co/b5mGQHx/yachts-1.png', 'template' => 1],
            ],
            'home_main_theme'                       => 'https://i.ibb.co/r0j7mGx/home-Header.png',
            'specs_keys'                            => ['engine_type'],
            'android_app_version'                   => '1.0',
            'android_force_updated'                 => false,
            'android_force_updated_link'            => '',
            'ios_app_version'                       => '1.0',
            'ios_force_updated'                     => false,
            'ios_force_updated_link'                => '',
            'default_country'                       => 'AE',
            'default_city'                          => 'DU',
            'darbi_percentage'                      => 20
        ];

        Setting::create($settings);
    }
}
