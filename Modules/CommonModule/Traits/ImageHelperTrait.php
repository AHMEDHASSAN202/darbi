<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

trait ImageHelperTrait
{
    public function resizeImage($folder, $image, $sizes = ['400x400'])
    {
        $imageResizeName = pathinfo($image, PATHINFO_FILENAME);
        foreach ($sizes as $size) {
            $s = explode('x', $size, 2);
            $width = $s[0];
            $height = $s[1];
            $imageResizeName .= '-resize-' . $size;

            try {
                Image::make($image)->fit($width, $height)->save($folder);
            }catch (\Exception $exception) {
                Log::error($exception->getMessage());
                if (app()->environment('local')) {
                    dd($exception);
                }
            }
        }
    }

    public function uploadImage($folder, UploadedFile $image, $resizes = [], $disc = 'public')
    {
        $imagePath = $image->store($folder, $disc);

        if (!empty($resizes)) {
            $folderPath = Storage::disk($disc)->path($folder);
            $this->resizeImage($folderPath, $imagePath, $resizes);
        }

        return $imagePath;
    }

    public function uploadImages($folder, $images, $resizes = [], $disc = 'public')
    {
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

    public function uploadAvatar(UploadedFile $avatar, $folder = 'avatars', $sizes =  ['300x200'])
    {
        return $this->uploadImage($folder, $avatar, $sizes);
    }
}
