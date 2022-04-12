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
