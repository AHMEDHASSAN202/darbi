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
//        $settings = [
//            [
//                'group'         => 'system',
//                'title_ar'      => __('System Email', [], 'ar'),
//                'title_en'      => __('System Email', [], 'en'),
//                'key'           => 'system_email',
//                'value'         => 'system@dev.n-go.co',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'system',
//                'title_ar'      => __('Default Language', [], 'ar'),
//                'title_en'      => __('Default Language', [], 'en'),
//                'key'           => 'default_lang',
//                'value'         => 'en',
//                'type'          => 'select',
//                'data'          => [['label' => 'العربية', 'value' => 'ar'], ['label' => 'English', 'value' => 'en']]
//            ],
//            [
//                'group'         => 'services',
//                'title_ar'      => __('Google Analytics ID', [], 'ar'),
//                'title_en'      => __('Google Analytics ID', [], 'en'),
//                'key'           => 'google_analytics_id',
//                'value'         => 'UA-97434832-1',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'services',
//                'title_ar'      => __('Google Maps Key', [], 'ar'),
//                'title_en'      => __('Google Maps Key', [], 'en'),
//                'key'           => 'google_maps_key',
//                'value'         => 'AIzaSyAca0f-WVNBWeGbbsw9kjmGI13z_J0SwPw',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mailchimp',
//                'title_ar'      => __('API Key', [], 'ar'),
//                'title_en'      => __('API Key', [], 'en'),
//                'key'           => 'mailchimp_api_key',
//                'value'         => 'ee2974048a76fbd3b2b5a773c836d828-us2',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mailchimp',
//                'title_ar'      => __('List ID', [], 'ar'),
//                'title_en'      => __('List ID', [], 'en'),
//                'key'           => 'mailchimp_list_id',
//                'value'         => 'f4e5e86a6e',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'seo',
//                'title_ar'      => __('SEO Title', [], 'ar'),
//                'title_en'      => __('SEO Title', [], 'en'),
//                'key'           => 'seo_title',
//                'value'         => 'NGO',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'seo',
//                'title_ar'      => __('SEO Description', [], 'ar'),
//                'title_en'      => __('SEO Description', [], 'en'),
//                'key'           => 'seo_description',
//                'value'         => '',
//                'type'          => 'textarea',
//                'data'          => []
//            ],
//            [
//                'group'         => 'seo',
//                'title_ar'      => __('SEO Keywords', [], 'ar'),
//                'title_en'      => __('SEO Keywords', [], 'en'),
//                'key'           => 'seo_keywords',
//                'value'         => '',
//                'type'          => 'textarea',
//                'data'          => []
//            ],
//            [
//                'group'         => 'seo',
//                'title_ar'      => __('Facebook AppID', [], 'ar'),
//                'title_en'      => __('Facebook AppID', [], 'en'),
//                'key'           => 'seo_facebook_appid',
//                'value'         => '',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Background Color', [], 'ar'),
//                'title_en'      => __('Background Color', [], 'en'),
//                'key'           => 'mail_design_background_color',
//                'value'         => '#53585F',
//                'type'          => 'color',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Logo', [], 'ar'),
//                'title_en'      => __('Logo', [], 'en'),
//                'key'           => 'mail_design_logo',
//                'value'         => '',
//                'type'          => 'image',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Border Radius', [], 'ar'),
//                'title_en'      => __('Border Radius', [], 'en'),
//                'key'           => 'mail_design_border_radius',
//                'value'         => '',
//                'type'          => 'number',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Header Display', [], 'ar'),
//                'title_en'      => __('Header Display', [], 'en'),
//                'key'           => 'mail_design_header_display',
//                'value'         => '',
//                'type'          => 'select',
//                'data'          => [['label' => 'Logo', 'value' => 'logo'], ['label' => 'Text', 'value' => 'text']]
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Header Display', [], 'ar'),
//                'title_en'      => __('Header Display', [], 'en'),
//                'key'           => 'mail_design_header_content',
//                'value'         => '',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Header Background Color', [], 'ar'),
//                'title_en'      => __('Header Background Color', [], 'en'),
//                'key'           => 'mail_design_header_background_color',
//                'value'         => '#FFFFFF',
//                'type'          => 'color',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Header Text Color', [], 'ar'),
//                'title_en'      => __('Header Text Color', [], 'en'),
//                'key'           => 'mail_design_header_text_color',
//                'value'         => '#222222',
//                'type'          => 'color',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Header Text Size', [], 'ar'),
//                'title_en'      => __('Header Text Size', [], 'en'),
//                'key'           => 'mail_design_header_text_size',
//                'value'         => '30',
//                'type'          => 'number',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Header Alignment', [], 'ar'),
//                'title_en'      => __('Header Alignment', [], 'en'),
//                'key'           => 'mail_design_header_alignment',
//                'value'         => 'center',
//                'type'          => 'select',
//                'data'          => [['label' => 'Center', 'value' => 'center'], ['label' => 'Left', 'value' => 'left'], ['label' => 'Right', 'value' => 'right']]
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Body Background Color', [], 'ar'),
//                'title_en'      => __('Body Background Color', [], 'en'),
//                'key'           => 'mail_design_body_background_color',
//                'value'         => '#FFFFFF',
//                'type'          => 'color',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Body Text Color', [], 'ar'),
//                'title_en'      => __('Body Text Color', [], 'en'),
//                'key'           => 'mail_design_body_text_color',
//                'value'         => '#222222',
//                'type'          => 'color',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Body Text Size', [], 'ar'),
//                'title_en'      => __('Body Text Size', [], 'en'),
//                'key'           => 'mail_design_body_text_size',
//                'value'         => '30',
//                'type'          => 'number',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Body Alignment', [], 'ar'),
//                'title_en'      => __('Body Alignment', [], 'en'),
//                'key'           => 'mail_design_body_alignment',
//                'value'         => 'center',
//                'type'          => 'select',
//                'data'          => [['label' => 'Center', 'value' => 'center'], ['label' => 'Left', 'value' => 'left'], ['label' => 'Right', 'value' => 'right']]
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Footer Content', [], 'ar'),
//                'title_en'      => __('Footer Content', [], 'en'),
//                'key'           => 'mail_design_footer_content',
//                'value'         => '',
//                'type'          => 'textarea',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Footer Background Color', [], 'ar'),
//                'title_en'      => __('Footer Background Color', [], 'en'),
//                'key'           => 'mail_design_footer_background_color',
//                'value'         => '#FFFFFF',
//                'type'          => 'color',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Footer Text Color', [], 'ar'),
//                'title_en'      => __('Footer Text Color', [], 'en'),
//                'key'           => 'mail_design_footer_text_color',
//                'value'         => '#222222',
//                'type'          => 'color',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Footer Text Size', [], 'ar'),
//                'title_en'      => __('Footer Text Size', [], 'en'),
//                'key'           => 'mail_design_footer_text_size',
//                'value'         => '30',
//                'type'          => 'number',
//                'data'          => []
//            ],
//            [
//                'group'         => 'mail_design',
//                'title_ar'      => __('Footer Alignment', [], 'ar'),
//                'title_en'      => __('Footer Alignment', [], 'en'),
//                'key'           => 'mail_design_footer_alignment',
//                'value'         => 'center',
//                'type'          => 'select',
//                'data'          => [['label' => 'Center', 'value' => 'center'], ['label' => 'Left', 'value' => 'left'], ['label' => 'Right', 'value' => 'right']]
//            ],
//            //smtp
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('Email Address', [], 'ar'),
//                'title_en'      => __('Email Address', [], 'en'),
//                'key'           => 'smtp_email_address',
//                'value'         => '',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('From Name', [], 'ar'),
//                'title_en'      => __('From Name', [], 'en'),
//                'key'           => 'smtp_from_name',
//                'value'         => '',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('Encryption Type', [], 'ar'),
//                'title_en'      => __('Encryption Type', [], 'en'),
//                'key'           => 'smtp_encryption_type',
//                'value'         => '',
//                'type'          => 'radio',
//                'data'          => [['label' => 'None', 'value' => 'none'], ['label' => 'SSL', 'value' => 'ssl'], ['label' => 'TLS', 'value' => 'tls']]
//            ],
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('SMTP Host', [], 'ar'),
//                'title_en'      => __('SMTP Host', [], 'en'),
//                'key'           => 'smtp_host',
//                'value'         => 'smtp-relay.sendinblue.com',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('SMTP Port', [], 'ar'),
//                'title_en'      => __('SMTP Port', [], 'en'),
//                'key'           => 'smtp_port',
//                'value'         => '587',
//                'type'          => 'number',
//                'data'          => []
//            ],
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('SMTP Authentication', [], 'ar'),
//                'title_en'      => __('SMTP Authentication', [], 'en'),
//                'key'           => 'smtp_authentication',
//                'value'         => 'yes',
//                'type'          => 'radio',
//                'data'          => [['label' => 'Yes', 'value' => 'yes'], ['label' => 'No', 'value' => 'no']]
//            ],
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('SMTP Username', [], 'ar'),
//                'title_en'      => __('SMTP Username', [], 'en'),
//                'key'           => 'smtp_username',
//                'value'         => 'ifadbad@gmail.com',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'smtp',
//                'title_ar'      => __('SMTP Password', [], 'ar'),
//                'title_en'      => __('SMTP Password', [], 'en'),
//                'key'           => 'smtp_password',
//                'value'         => '',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'onesingle',
//                'title_ar'      => __('App ID', [], 'ar'),
//                'title_en'      => __('App ID', [], 'en'),
//                'key'           => 'onesingle_app_id',
//                'value'         => 'd10c5ae1-2910-472a-a2fd-c06544f6de91',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'onesingle',
//                'title_ar'      => __('Rest API Key', [], 'ar'),
//                'title_en'      => __('Rest API Key', [], 'en'),
//                'key'           => 'onesingle_rest_api_key',
//                'value'         => '',
//                'type'          => 'text',
//                'data'          => []
//            ],
//            [
//                'group'         => 'onesingle',
//                'title_ar'      => __('User Auth Key', [], 'ar'),
//                'title_en'      => __('User Auth Key', [], 'en'),
//                'key'           => 'onesingle_user_auth_key',
//                'value'         => '',
//                'type'          => 'text',
//                'data'          => []
//            ],
//        ];

        $settings = [
            'time_interval_vendor_accept_min'       => 22,
            'time_interval_user_accept_min'         => 22,
            'walk_through_images'                   => [],
            'home_main_theme'                       => '',
            'specs_keys'                            => ['engine_type']
        ];

        Setting::create($settings);
    }
}
