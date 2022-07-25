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
    if (auth('api')->check()) {
        return 'api';
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

function imageUrl(?string $image, $displayType = 'middle', $customSize = null) {
    if (!$image) {
        return '';
    }

    if (filter_var($image, FILTER_VALIDATE_URL)) {
        return $image;
    }

    $image = \Illuminate\Support\Facades\Storage::disk('s3')->url($image);

    if ($displayType === 'thumbnail') {
        $image = addSizeToImageLink($image, 200);
    }elseif ($displayType === 'middle') {
        $image = addSizeToImageLink($image, 600);
    }elseif ($displayType === 'original') {
        return $image;
    }

    if ($customSize) {
        $image = addSizeToImageLink($image, $customSize);
    }

    return $image;
}


function imagesUrl(array $images, $displayType = 'middle') {
    return array_map(function ($image) use ($displayType) { return imageUrl($image, $displayType); }, $images);
}

function addSizeToImageLink($imageLink, $size)
{
    $imageInfo = pathinfo($imageLink);
    if (!isset($imageInfo['extension'])) {
        return $imageLink;
    }
    return $imageInfo['dirname'] . '/' . $imageInfo['filename'] . '-resize-' . $size . 'x' . $size . '.' . $imageInfo['extension'];
}

function translateAttribute(array | object | null | string $attribute, $locale = null) {
    if (!$attribute) {
        return '';
    }

    if (empty($attribute)) {
        return '';
    }

    if (is_string($attribute)) {
        return $attribute;
    }

    if (!$locale) {
        $locale = app()->getLocale();
    }

    if (is_array($attribute)) {
        return @$attribute[$locale] ?? @$attribute['en'];
    }

    return @$attribute->{$locale} ?? @$attribute->en;
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
    return ($state === \Modules\CatalogModule\Enums\EntityStatus::FREE);
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

function getBrandTestImages()
{
    return [
        'https://i.ibb.co/jf53hBr/carType0.png',
        'https://i.ibb.co/1zymqCW/Bentley.png',
        'https://i.ibb.co/qyKvWNY/BMW.png',
        'https://i.ibb.co/C1WgKtG/jaguar.png',
        'https://i.ibb.co/F8dhpZW/Lamborghini.png',
        'https://i.ibb.co/QK5D5NV/mercedes.png',
        'https://i.ibb.co/P4zB4bR/Porsche.png',
        'https://i.ibb.co/ZG2xJK5/Rolls.png'
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

function generateObjectIdOfArrayValues($ids) : array
{
    if (empty($ids)) {
        return [];
    }

    return array_map(function ($id) { return new \MongoDB\BSON\ObjectId($id); }, $ids);
}

function locationInfoKeys() : array
{
    return [
        'id', 'lat', 'lng', 'fully_addressed', 'city', 'country', 'state', 'region_id'
    ];
}

function convertBsonArrayToCollection($bsonArray)
{
    $objects = array_map(function ($object) { return (object)$object; }, (array)$bsonArray);

    return collect($objects);
}

function convertBsonArrayToNormalArray($bsonArray)
{
    if (is_array($bsonArray)) {
        return $bsonArray;
    }

    return (array)$bsonArray->jsonSerialize();
}

function exportData($filename, array $columns, array $data)
{
    array_unshift($data, $columns);

    return fastexcel()->data(collect($data))->download($filename);
}

function convertDateTimeToUTC($me, string $datetime)
{
    return new \MongoDB\BSON\UTCDateTime(new DateTime($datetime));
}

function arrayGet($array, $key, $default = null)
{
    if (!is_array($array)) {
        return null;
    }
    return @$array[$key] ?? $default;
}

function objectGet($obj, $property, $default = null)
{
    if (!is_object($obj)) {
        return null;
    }
    return @$obj->{$property} ?? $default;
}

function slugify($text, string $divider = '-') {
    if (is_null($text)) {
        return '';
    }

    if (strlen($text) > 2000) {
        $text = substr($text, 0, 2000);
    }

    $text = trim($text);

    $text = mb_strtolower($text, "UTF-8");

    $text = preg_replace('/[^\x{0600}-\x{06FF}a-z0-9_] /u','', $text);

    $text = preg_replace("/[!@#$%^&?<>*()]+/", " ", $text);

    $text = preg_replace("/[\s-]+/", " ", $text);

    $text = preg_replace("/[\s_]/", $divider, $text);

    return $text;
}

function serviceResponse($data, $statusCode = 200, $message = '')
{
    return [
        'data'          => $data,
        'statusCode'    => $statusCode,
        'message'       => $message
    ];
}

function successResponse($data = [], $message = null)
{
    return serviceResponse($data, 200, $message);
}

function createdResponse($data = [], $message = null)
{
    return serviceResponse($data, 201, $message ?? __('Data has been added successfully'));
}

function updatedResponse($data = [], $message = null)
{
    return serviceResponse($data, 200, $message ?? __('Data has been updated successfully'));
}

function deletedResponse($data = [], $message = null)
{
    return serviceResponse($data, 200, $message ?? __('Data has been deleted successfully'));
}

function badResponse($data = [], $message = null)
{
    return serviceResponse($data, 400, $message);
}

function serverErrorResponse($data = [], $message = null)
{
    return serviceResponse($data, 500, $message ?? __('Internal server error'));
}

function helperLog($class, $method, $message = null, $context = [])
{
    \Illuminate\Support\Facades\Log::error($class . ' -> ' . $method . ' -> ' . $message, (empty($context) ? request()->all() : $context));
}

function getLocalesWord($key, $replace = [])
{
    return ['ar' => __($key, $replace, 'ar'), 'en' => __($key, $replace, 'en')];
}

function phoneCodeCleaning($phoneCode)
{
    if (str_starts_with($phoneCode, '+')) {
        $phoneCode = substr($phoneCode, 1);
    }
    if (str_starts_with($phoneCode, '00')) {
        $phoneCode = substr($phoneCode, 2);
    }
    return $phoneCode;
}
