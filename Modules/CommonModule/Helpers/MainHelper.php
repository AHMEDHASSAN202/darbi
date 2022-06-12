<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */


function getCurrentGuard() {
    if (auth('admin_api')->check()) {
        return 'admin_api';
    }
    if (auth('vendor_api')->check()) {
        return 'vendor_api';
    }
    return null;
}

function activities() {
    return app(\Modules\CommonModule\Repositories\ActivityRepository::class);
}

function kebabToWords($str) {
    if(empty($str)) return $str;
    $pieces = preg_split('/(?=[A-Z])/', $str);
    $string = implode(' ', $pieces);
    $string = ucwords($string);
    return $string;
}

function assetsHelper() {
    return \Modules\CommonModule\Helpers\Assets::instance();
}

function imageUrl(?string $image, $dir = '', $size = null) {
    if (!$image) return '';
    $image = filter_var($image, FILTER_VALIDATE_URL) ? $image : asset('storage/'. $dir . $image);
    if ($size) {
        $image = addSizeToImageLink($image, $size);
    }
    return $image;
}

function addSizeToImageLink($imageLink, $size)
{
    $imageInfo = pathinfo($imageLink);
    if (!isset($imageInfo['extension'])) {
        return $imageLink;
    }
    return $imageInfo['dirname'] . '/' . $imageInfo['filename'] . '-resize-' . $size . '.' . $imageInfo['extension'];
}

function translateAttribute(?array $attribute, $locale = null) {
    if (!$attribute) {
        return '';
    }

    if (empty($attribute)) {
        return '';
    }

    if (!$locale) {
        $locale = app()->getLocale();
    }

    return $attribute[$locale] ?? $attribute['en'];
}

function generatePriceLabelFromPrice(?float $price, $priceUnit) : string
{
    if (!$price) {
        \Illuminate\Support\Facades\Log::error('Why Price is Null!!');
        return '';
    }

    return sprintf("%.2f %s / %s", $price, __('SAR'), __($priceUnit));
}

function generateOTPCode()
{
    return (!app()->environment('production')) ? 1234 : mt_rand(1000,9999);
}

function hasEmbed($param) : bool
{
    if ($embedParam = request('embed')) {
        $embed = explode(',', $embedParam);
        return in_array($param, $embed);
    }
    return false;
}

function entityIsFree($state) : bool
{
    return ($state === 'free');
}

function getCarTestImages()
{
    return [
        'https://i.ibb.co/YXhsjFy/004.png',
        'https://i.ibb.co/pdy17f0/005.png',
        'https://i.ibb.co/VgWV0nT/006.png',
        'https://i.ibb.co/VgWV0nT/006.png',
        'https://i.ibb.co/D9vvxyj/003-Copy.png',
        'https://i.ibb.co/xS7MKH3/010.png',
        'https://i.ibb.co/hgvwHRB/009-Copy.png',
        'https://i.ibb.co/1bkScty/008-Copy.png',
    ];
}

function getAvatarTestImages()
{
    return [
        'https://i.ibb.co/HHSWQq2/Group-12347.png',
        'https://i.ibb.co/F6xhw5H/Group-12348.png',
        'https://i.ibb.co/0KCJ97Q/Group-12349.png',
        'https://i.ibb.co/jy37yWb/Group-12351.png',
    ];
}

function getYatchTestImages()
{
    return [
        'https://i.ibb.co/cQF4TTm/Rectangle-8247.png',
        'https://i.ibb.co/j39VDqF/Rectangle-8246.png',
        'https://i.ibb.co/0c0gwDC/Rectangle-8241.png',
        'https://i.ibb.co/qW2dr2H/Rectangle-8242.png',
        'https://i.ibb.co/gvKsZSj/Rectangle-8233.png',
        'https://i.ibb.co/CVshB3X/Rectangle-8232.png',
        'https://i.ibb.co/2qXy1QY/Rectangle-7513.png',
        'https://i.ibb.co/mSkD0zt/Rectangle-8230.png',
        'https://i.ibb.co/KVgGG9C/Rectangle-8229.png'
    ];
}

function getRandomImages(array $images, $length = 3)
{
    $imgs = [];
    while ($length > 0) {
        $imgs[] = $images[mt_rand(0, (count($images) - 1))];
        $length--;
    }
    return $imgs;
}

function getOption($option, $default = null)
{
    $settings = app(\Modules\CommonModule\Services\SettingService::class)->getSettings();

    return @$settings->{$option} ?? $default;
}

function getVendorId()
{
    return auth('vendor_api')->user()->vendor_id;
}

function generateObjectIdOfArrayValues($ids)
{
    return array_map(function ($id) { return new \MongoDB\BSON\ObjectId($id); }, $ids);
}
