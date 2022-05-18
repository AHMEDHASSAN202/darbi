<?php

/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

function scanDirectories($currentRelativePath, $rootPath, $baseUrl) : array {
    $result = [];
    $path = $rootPath . $currentRelativePath;
    $preventFileOrDirectories = ['.', '..', '.gitignore'];

    if (!file_exists($path)) {
        return [];
    }

    $directories = scandir($path);

    foreach ($directories as $value) {
        if (!in_array($value, $preventFileOrDirectories)) {
            if (is_dir($path . DIRECTORY_SEPARATOR . $value)) {
                $result[] = [
                    'type'      => 'directory',
                    'name'      => $value,
                    'size'      => fileSizeConvert(getDirectorySize($path . DIRECTORY_SEPARATOR . $value)),
                    'path'      => str_replace([DIRECTORY_SEPARATOR, '//'], '/', $currentRelativePath . '/') . $value
                ];
            } else {
                $result[] = [
                    'type'      => 'file',
                    'size'      => fileSizeConvert(filesize($path . DIRECTORY_SEPARATOR . $value)),
                    'mime_type' => mime_content_type($path . DIRECTORY_SEPARATOR . $value),
                    'name'      => $value,
                    'path'      => str_replace([DIRECTORY_SEPARATOR, '//'], '/', $currentRelativePath . '/') . $value,
                    'link'      => resolveUrl($baseUrl, $currentRelativePath . '/' . $value),
                ];
            }
        }
    }

    return $result;
}


function fileSizeConvert($bytes) : string {
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );

    foreach($arBytes as $arItem) {
        if($bytes >= $arItem["VALUE"]) {
            $result = $bytes / $arItem["VALUE"];
            return str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
        }
    }
    return '0 KB';
}


function getDirectorySize($path) {
    $bytestotal = 0;
    $path = realpath($path);
    if($path !== false && $path != '' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}


function resolveUrl($baseUrl, $path) {
    return clearDblSlash("{$baseUrl}/{$path}");
}


function clearDblSlash($str) {
    $str = preg_replace('/\/+/', '/', $str);
    $str = str_replace(':/', '://', $str);

    return $str;
}
