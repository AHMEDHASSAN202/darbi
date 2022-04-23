<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\FileManagerModule\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileManagerService
{
    private $storageDisk;
    private $rootPath;
    private $baseUrl;

    public function __construct()
    {
        $this->storageDisk = Storage::disk('public');
        $this->rootPath = $this->storageDisk->path('/');
        $this->baseUrl = $this->storageDisk->url('/');
    }

    public function getDirectories($request)
    {
        $currentPath = $request->get('path', '/');
        $files = scanDirectories($currentPath, $this->rootPath, $this->baseUrl);
        $files = collect($files)->sortBy(function ($file) { return $file['type'] != 'directory'; })->values()->toArray();

        return $files;
    }

    public function uploadFile($request)
    {
        $uploadPath = $request->upload_path;

        $path = $this->storageDisk->putFile($uploadPath, $request->file);

        return [
            'status' => true,
            'file'   => $this->fileInfo($this->rootPath . $path, $path)
        ];
    }

    public function uploadFileFromLink($request)
    {
        $uploadPath = $request->upload_path;

        $path = $this->storageDisk->put($uploadPath, file_get_contents($request->file));

        return ['status' => true, 'file' => $this->fileInfo($this->rootPath.$path, $path)];
    }

    public function croppedImage($request)
    {
        $w = $request->w;
        $h = $request->h;
        $x = $request->x;
        $y = $request->y;
        $imagePath  = $request->image;
        $imagePathInfo = pathinfo($imagePath);

        if (!$this->storageDisk->exists($request->image)) {
            return ['status' => false, 'msg' => __('the image does not exist')];
        }

        try {

            $image = Image::make($this->storageDisk->path($imagePath));
            $croppedImageName = $imagePathInfo['filename'] . '-resize-' . $w . 'x' . $h . '.' . $imagePathInfo['extension'];
            $croppedImagePath = $imagePathInfo['dirname'] . DIRECTORY_SEPARATOR . $croppedImageName;
            $croppedImageFullPath  = $this->storageDisk->path($croppedImagePath);

            $image->crop($w, $h, $x, $y);
            $image->save($croppedImageFullPath);

            return [
                'status'    => true,
                'file'      => $this->fileInfo($croppedImageFullPath, $croppedImagePath)
            ];
        }catch (\Exception $exception) {
            return [
                'status'    => false,
                'msg'       => $exception->getMessage()
            ];
        }
    }

    private function fileInfo($fileFullPath, $fileRelativePath) {
        $fileRelativePath  = str_replace([DIRECTORY_SEPARATOR, '//'], '/', $fileRelativePath);
        return [
            'type'      => 'file',
            'size'      => fileSizeConvert(filesize($fileFullPath)),
            'mime_type' => mime_content_type($fileFullPath),
            'name'      => pathinfo($fileRelativePath, PATHINFO_BASENAME),
            'path'      => $fileRelativePath,
            'link'      => resolveUrl($this->baseUrl, $fileRelativePath)
        ];
    }

    public function deleteItem($request)
    {
        $fullPath = $request->path;

        if (!$this->storageDisk->exists($fullPath)) {
            return ['status' => false, 'msg' => __('the file does not exist')];
        }

        if (is_dir($this->storageDisk->path($fullPath))) {
            $deleted = $this->storageDisk->deleteDirectory($fullPath);
        }else {
            $deleted  = $this->storageDisk->delete($fullPath);
        }

        if (!$deleted) {
            return ['status' => false, 'msg' => __('an error occurred while deleting the file')];
        }

        return ['status' => true];
    }

    public function createDirectory($request)
    {
        $directoryFullPath = $request->path . DIRECTORY_SEPARATOR . $request->directory_name;

        if ($this->storageDisk->exists($directoryFullPath)) {
            return ['status' => false, 'msg' => __('the directory does not exist')];
        }

        $created = $this->storageDisk->makeDirectory($directoryFullPath);

        if (!$created) {
            return ['status' => false, 'msg' => __('an error occurred while creating the directory')];
        }

        return ['status' => true];
    }

    public function renameFile($request)
    {
        $path = $request->path;
        $newName = $request->new_name;
        $type  = $request->get('type', 'file');
        $directoryPath = dirname($path);

        if ($type == 'file') {
            $newPath = $directoryPath . DIRECTORY_SEPARATOR . $newName . '.' . pathinfo($path, PATHINFO_EXTENSION);
        }else {
            $newPath = $directoryPath . DIRECTORY_SEPARATOR . $newName;
        }

        if ($this->storageDisk->exists($newPath)) {
            return ['status' => false, 'msg' => __('the file does not exist')];
        }

        $moved = $this->storageDisk->move($path, $newPath);

        if (!$moved) {
            return ['status' => false, 'msg' => __('sometimes error!')];
        }

        return ['status' => true];
    }

    public function moveItem($request)
    {
        $fromPath = $request->from_path;
        $toPath  = $request->to_path;
        $file  = $request->file;
        $copy  = $request->get('use_copy', false);
        $type  = $request->get('type', 'file');

        if ($type == 'file') {
            $fromFullPath = $fromPath . DIRECTORY_SEPARATOR . $file;
            $toFullPath  = $toPath . DIRECTORY_SEPARATOR . $file;
        }else {
            $fromFullPath = $fromPath;
            $toFullPath  = $toPath;
        }

        if ($copy) {
            if ($type == 'directory') {
                $status = app('files')->copyDirectory($this->storageDisk->path($fromFullPath), $this->storageDisk->path($toFullPath));
            }else {
                $status = $this->storageDisk->copy($fromFullPath, $toFullPath);
            }
        }else {
            $status = $this->storageDisk->move($fromFullPath, $toFullPath);
        }

        if (!$status) {
            return ['status' => false, 'msg' => 'something error!'];
        }

        return ['status' => true];
    }
}
