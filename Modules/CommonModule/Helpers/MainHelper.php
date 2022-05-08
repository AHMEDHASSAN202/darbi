<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */


function getFirstError($errors) {
    if (!is_array($errors) || empty($errors)) return [];

    $err = [];

    foreach ($errors as $key => $error) {
        $err[$key] = $error[0];
    }

    return $err;
}

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

function kebabToWords($str){
    if(empty($str)) return $str;
    $pieces = preg_split('/(?=[A-Z])/', $str);
    $string = implode(' ', $pieces);
    $string = ucwords($string);
    return $string;
}

function assetsHelper() {
    return \Modules\CommonModule\Helpers\Assets::instance();
}
