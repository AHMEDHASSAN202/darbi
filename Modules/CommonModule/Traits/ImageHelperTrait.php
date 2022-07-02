<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait ImageHelperTrait
{
    public function resizeImage($folder, $image, $sizes = ['400x400'])
    {
        $imageInfo = pathinfo($image);
        $imageResizeName = $imageInfo['filename'];
        foreach ($sizes as $size) {
            $s = explode('x', $size, 2);
            $width = $s[0];
            $height = $s[1];
            $imageResizeName .= '-resize-' . $size . '.' . $imageInfo['extension'];

            try {
                \Image::make(Storage::path($image))->fit($width, $height)->save($folder . DIRECTORY_SEPARATOR . $imageResizeName);
            }catch (\Exception $exception) {
                Log::error($exception->getMessage());
                if (app()->environment('local')) {
                    dd($exception);
                }
            }
        }
    }

    public function uploadImage($folder, UploadedFile $image, $resizes = [], $disc = 's3')
    {
        $imagePath = $image->store($folder, $disc);

        Storage::disk($disc)->setVisibility($imagePath, 'public');

        if (!empty($resizes)) {
//            $folderPath = Storage::disk($disc)->path($folder);
//            $this->resizeImage($folderPath, $imagePath, $resizes);
        }

        return $imagePath;
    }

    public function uploadImages($folder, $images, $resizes = [], $disc = 's3')
    {
        if (!is_array($images) || empty($images)) {
            return [];
        }

        $imagePaths = [];
        foreach ($images as $image) {
            try {
                $imagePaths[] = $this->uploadImage($folder, $image, $resizes, $disc);
            }catch (\Exception $exception) {
                Log::error($exception->getMessage(), $images);
            }
        }

        return $imagePaths;
    }

    public function uploadAvatar(UploadedFile $avatar, $folder = 'avatars', $sizes =  ['300x300'])
    {
        return $this->uploadImage($folder, $avatar, $sizes);
    }

    public function _removeImage(null|string|array $images, $disc = 's3')
    {
        if (!$images) {
            return;
        }

        if (is_string($images)) {
            $images = [$images];
        }

        try {
            return Storage::disk($disc)->delete($images);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
