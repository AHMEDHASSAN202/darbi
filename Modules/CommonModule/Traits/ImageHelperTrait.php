<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageHelperTrait
{
    private $sizes = ['200x200', '600x600'];

    public function resizeImage($disc, $imageFullPath, UploadedFile $imageSrc, $sizes)
    {
        $imageInfo = pathinfo($imageFullPath);

        foreach ($sizes as $size) {
            $s = explode('x', $size, 2);
            $width = $s[0];
            $height = $s[1];
            $imageResizeName = $imageInfo['filename'] . '-resize-' . $size . '.' . $imageInfo['extension'];
            $imageFullPath = $imageInfo['dirname'] . DIRECTORY_SEPARATOR . $imageResizeName;

            try {

                $img = \Image::make($imageSrc)->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                Storage::disk($disc)->put($imageFullPath, $img->stream());
                Storage::disk($disc)->setVisibility($imageFullPath, 'public');

            }catch (\Exception $exception) {
                helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            }
        }
    }

    public function uploadImage($folder, UploadedFile $image, $resizes = null, $disc = 's3')
    {
        if (!$resizes) {
            $resizes = $this->sizes;
        }

        $imagePath = $image->store($folder, $disc);

        Storage::disk($disc)->setVisibility($imagePath, 'public');

        if (!empty($resizes)) {
            $this->resizeImage($disc, $imagePath, $image, $resizes);
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
                helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            }
        }

        return $imagePaths;
    }

    public function uploadAvatar(UploadedFile $avatar, $folder = 'avatars', $sizes = ['200x200'])
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
            $deleted = Storage::disk($disc)->delete($images);

            if ($deleted) {
                foreach ($images as $image) {
                    foreach ($this->sizes as $size) {
                        Storage::disk($disc)->delete(addSizeToImageLink($image, $size));
                    }
                }
            }

        } catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
        }
    }
}
