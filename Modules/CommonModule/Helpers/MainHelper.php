<?php

use Carbon\Carbon;

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
    return app()->environment('production') ? mt_rand(1000,9999) : 1234;
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

function entityIsReserved($state) : bool
{
    return ($state === \Modules\CatalogModule\Enums\EntityStatus::RESERVED);
}

function entityIsCar($type) : bool
{
    return ($type === \Modules\CatalogModule\Enums\EntityType::CAR);
}

function entityIsYacht($type) : bool
{
    return ($type === \Modules\CatalogModule\Enums\EntityType::YACHT);
}

function entityIsVilla($type) : bool
{
    return ($type === \Modules\CatalogModule\Enums\EntityType::VILLA);
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

function getVillaTestImages()
{
    return [
        'https://i.ibb.co/bKC4wxX/Rectangle-8263-4-3x.png',
        'https://i.ibb.co/pj2Twq4/Rectangle-8263-5-3x.png',
        'https://i.ibb.co/DtyWyRv/Rectangle-8263-6-3x.png',
        'https://i.ibb.co/zX9pX8h/Rectangle-8263-3x.png',
        'https://i.ibb.co/Qkrqfgx/Rectangle-8263-2-3x.png',
        'https://i.ibb.co/47n9C67/Rectangle-8263-3-3x.png'
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

function generateStringIdOfArrayValues($ids) : array
{
    if (empty($ids)) {
        return [];
    }

    return array_map(function ($id) { return (string)$id; }, $ids);
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

function convertBsonArrayToArray($bsonArray)
{
    return array_map(function ($object) { return (array)$object; }, (array)$bsonArray);
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

function getLanguage($default = 'ar'){
    if (\Cookie::has('language')) {
        $languageInCookie = explode('|', \Illuminate\Support\Facades\Crypt::decrypt(\Cookie::get('language'), false));
        return @end($languageInCookie);
    }
    return $default;
}

function setLanguage($lang){
    if(!empty($lang)){
        $lang = trim(strtolower($lang));
        $lang = substr($lang, 0, 2);
        app()->setLocale($lang);
        \Cookie::queue('language', $lang, 120);
    }
    return $lang;
}

function getTwitterUsernameFromUrl($url)
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return $url;
    }
    $path = parse_url($url,PHP_URL_PATH);
    return @explode('/', trim($path, '/'))[0];
}

function getBookingEndDate($priceUnit, $startDate, $endDate)
{
    $startAt = Carbon::parse($startDate);
    $endAy = Carbon::parse($endDate);

    if ($priceUnit === 'hour') {

        $hours = ceil($startAt->floatDiffInHours($endAy));

        return $startAt->addHours($hours)->format('Y-m-d H:i:00');

    }elseif ($priceUnit === 'day') {

        $days = ceil($startAt->floatDiffInDays($endAy));

        return $startAt->addDays($days)->format('Y-m-d H:i:00');
    }

    throw new \Exception("Price unit not exists");
}

function getBookingNumber()
{
    return intval(date('ymd').mt_rand(000000,999999));
}

function countriesCallingCodes(){
    return [
        'AC' => '247',
        'AD' => '376',
        'AE' => '971',
        'AF' => '93',
        'AG' => '1268',
        'AI' => '1264',
        'AL' => '355',
        'AM' => '374',
        'AO' => '244',
        'AQ' => '672',
        'AR' => '54',
        'AS' => '1684',
        'AT' => '43',
        'AU' => '61',
        'AW' => '297',
        'AX' => '358',
        'AZ' => '994',
        'BA' => '387',
        'BB' => '1246',
        'BD' => '880',
        'BE' => '32',
        'BF' => '226',
        'BG' => '359',
        'BH' => '973',
        'BI' => '257',
        'BJ' => '229',
        'BL' => '590',
        'BM' => '1441',
        'BN' => '673',
        'BO' => '591',
        'BQ' => '599',
        'BR' => '55',
        'BS' => '1242',
        'BT' => '975',
        'BW' => '267',
        'BY' => '375',
        'BZ' => '501',
        'CA' => '1',
        'CC' => '61',
        'CD' => '243',
        'CF' => '236',
        'CG' => '242',
        'CH' => '41',
        'CI' => '225',
        'CK' => '682',
        'CL' => '56',
        'CM' => '237',
        'CN' => '86',
        'CO' => '57',
        'CR' => '506',
        'CU' => '53',
        'CV' => '238',
        'CW' => '599',
        'CX' => '61',
        'CY' => '357',
        'CZ' => '420',
        'DE' => '49',
        'DJ' => '253',
        'DK' => '45',
        'DM' => '1767',
        'DO' => '1809',
        'DO' => '1829',
        'DO' => '1849',
        'DZ' => '213',
        'EC' => '593',
        'EE' => '372',
        'EG' => '20',
        'EH' => '212',
        'ER' => '291',
        'ES' => '34',
        'ET' => '251',
        'EU' => '388',
        'FI' => '358',
        'FJ' => '679',
        'FK' => '500',
        'FM' => '691',
        'FO' => '298',
        'FR' => '33',
        'GA' => '241',
        'GB' => '44',
        'GD' => '1473',
        'GE' => '995',
        'GF' => '594',
        'GG' => '44',
        'GH' => '233',
        'GI' => '350',
        'GL' => '299',
        'GM' => '220',
        'GN' => '224',
        'GP' => '590',
        'GQ' => '240',
        'GR' => '30',
        'GT' => '502',
        'GU' => '1671',
        'GW' => '245',
        'GY' => '592',
        'HK' => '852',
        'HN' => '504',
        'HR' => '385',
        'HT' => '509',
        'HU' => '36',
        'ID' => '62',
        'IE' => '353',
        'IL' => '972',
        'IM' => '44',
        'IN' => '91',
        'IO' => '246',
        'IQ' => '964',
        'IR' => '98',
        'IS' => '354',
        'IT' => '39',
        'JE' => '44',
        'JM' => '1876',
        'JO' => '962',
        'JP' => '81',
        'KE' => '254',
        'KG' => '996',
        'KH' => '855',
        'KI' => '686',
        'KM' => '269',
        'KN' => '1869',
        'KP' => '850',
        'KR' => '82',
        'KW' => '965',
        'KY' => '1345',
        'KZ' => '7',
        'LA' => '856',
        'LB' => '961',
        'LC' => '1758',
        'LI' => '423',
        'LK' => '94',
        'LR' => '231',
        'LS' => '266',
        'LT' => '370',
        'LU' => '352',
        'LV' => '371',
        'LY' => '218',
        'MA' => '212',
        'MC' => '377',
        'MD' => '373',
        'ME' => '382',
        'MF' => '590',
        'MG' => '261',
        'MH' => '692',
        'MK' => '389',
        'ML' => '223',
        'MM' => '95',
        'MN' => '976',
        'MO' => '853',
        'MP' => '1670',
        'MQ' => '596',
        'MR' => '222',
        'MS' => '1664',
        'MT' => '356',
        'MU' => '230',
        'MV' => '960',
        'MW' => '265',
        'MX' => '52',
        'MY' => '60',
        'MZ' => '258',
        'NA' => '264',
        'NC' => '687',
        'NE' => '227',
        'NF' => '672',
        'NG' => '234',
        'NI' => '505',
        'NL' => '31',
        'NO' => '47',
        'NP' => '977',
        'NR' => '674',
        'NU' => '683',
        'NZ' => '64',
        'OM' => '968',
        'PA' => '507',
        'PE' => '51',
        'PF' => '689',
        'PG' => '675',
        'PH' => '63',
        'PK' => '92',
        'PL' => '48',
        'PM' => '508',
        'PR' => '1787',
        'PR' => '1939',
        'PS' => '970',
        'PT' => '351',
        'PW' => '680',
        'PY' => '595',
        'QA' => '974',
        'QN' => '374',
        'QS' => '252',
        'QY' => '90',
        'RE' => '262',
        'RO' => '40',
        'RS' => '381',
        'RU' => '7',
        'RW' => '250',
        'SA' => '966',
        'SB' => '677',
        'SC' => '248',
        'SD' => '249',
        'SE' => '46',
        'SG' => '65',
        'SH' => '290',
        'SI' => '386',
        'SJ' => '47',
        'SK' => '421',
        'SL' => '232',
        'SM' => '378',
        'SN' => '221',
        'SO' => '252',
        'SR' => '597',
        'SS' => '211',
        'ST' => '239',
        'SV' => '503',
        'SX' => '1721',
        'SY' => '963',
        'SZ' => '268',
        'TA' => '290',
        'TC' => '1649',
        'TD' => '235',
        'TG' => '228',
        'TH' => '66',
        'TJ' => '992',
        'TK' => '690',
        'TL' => '670',
        'TM' => '993',
        'TN' => '216',
        'TO' => '676',
        'TR' => '90',
        'TT' => '1868',
        'TV' => '688',
        'TW' => '886',
        'TZ' => '255',
        'UA' => '380',
        'UG' => '256',
        'UK' => '44',
        'US' => '1',
        'UY' => '598',
        'UZ' => '998',
        'VA' => '379',
        'VA' => '39',
        'VC' => '1784',
        'VE' => '58',
        'VG' => '1284',
        'VI' => '1340',
        'VN' => '84',
        'VU' => '678',
        'WF' => '681',
        'WS' => '685',
        'XC' => '991',
        'XD' => '888',
        'XG' => '881',
        'XL' => '883',
        'XN' => '857',
        'XN' => '858',
        'XN' => '870',
        'XP' => '878',
        'XR' => '979',
        'XS' => '808',
        'XT' => '800',
        'XV' => '882',
        'YE' => '967',
        'YT' => '262',
        'ZA' => '27',
        'ZM' => '260',
        'ZW' => '263',
    ];
}

function getCountryCodeFromPhoneCode($phoneCode)
{
    $phoneCode = str_replace('+', '', $phoneCode);

    $phoneCodes = array_flip(countriesCallingCodes());

    return arrayGet($phoneCodes, $phoneCode);
}
