<?php

namespace Modules\FileManagerModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\FileManagerModule\Http\Requests\CreateDirectoryRequest;
use Modules\FileManagerModule\Http\Requests\CroppedImageRequest;
use Modules\FileManagerModule\Http\Requests\DeleteItemRequest;
use Modules\FileManagerModule\Http\Requests\MoveRequest;
use Modules\FileManagerModule\Http\Requests\RenameItemRequest;
use Modules\FileManagerModule\Http\Requests\UploadFileRequest;
use Modules\FileManagerModule\Http\Requests\UploadFromLinkRequest;
use Modules\FileManagerModule\Services\FileManagerService;

/**
 * @group file manager
 *
 * Management files
 */
class FileManagerModuleController extends Controller
{
    use ApiResponseTrait;

    private $fileManagerService;

    public function __construct(FileManagerService $fileManagerService)
    {
        $this->fileManagerService = $fileManagerService;
    }

    /**
     * get files in path.
     *
     * @queryParam path string required
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $directories = $this->fileManagerService->getDirectories($request);

        return $this->apiResponse(compact('directories'));
    }

    /**
     * upload new files.
     *
     * @bodyParam file (File) required
     * @bodyParam upload_path string required
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(UploadFileRequest $uploadFileRequest)
    {
        $result = $this->fileManagerService->uploadFile($uploadFileRequest);

        if (!$result['status']) {
            return $this->apiResponse([], 400, $result['msg']);
        }

        return $this->apiResponse(['file' => $result['file']], 200, __('file uploaded successfully'));
    }

    /**
     * save image from link.
     *
     * @bodyParam file string required
     * @bodyParam upload_path string required
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFromLink(UploadFromLinkRequest $uploadFromLinkRequest)
    {
        $result = $this->fileManagerService->uploadFileFromLink($uploadFromLinkRequest);

        if (!$result['status']) {
            return $this->apiResponse([], 400,$result['msg']);
        }

        return $this->apiResponse(['file' => $result['file']], 200, __('file uploaded successfully'));
    }

    /**
     * save cropped image.
     *
     * @bodyParam image string required
     * @bodyParam w number required
     * @bodyParam h number required
     * @bodyParam x number required
     * @bodyParam y number required
     * @return \Illuminate\Http\JsonResponse
     */
    public function croppedImage(CroppedImageRequest $croppedImageRequest)
    {
        $result  = $this->fileManagerService->croppedImage($croppedImageRequest);

        if (!$result['status']) {
            return $this->apiResponse([], 400, $result['msg']);
        }

        return $this->apiResponse(['file' => $result['file']], 200, __('photo cropped successfully'));
    }

    /**
     * delete files/folders.
     *
     * @bodyParam path string required
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteItemRequest $deleteItemRequest)
    {
        $result = $this->fileManagerService->deleteItem($deleteItemRequest);

        if (!$result['status']) {
            return $this->apiResponse([], 400, $result['msg']);
        }

        return $this->apiResponse([], 200, __('the file has been deleted successfully'));
    }

    /**
     * create new folder.
     *
     * @bodyParam directory_name string required
     * @bodyParam path string required
     * @return \Illuminate\Http\JsonResponse
     */
    public function createDirectory(CreateDirectoryRequest $createDirectoryRequest)
    {
        $result = $this->fileManagerService->createDirectory($createDirectoryRequest);

        if (!$result['status']) {
            return $this->apiResponse([], 400, $result['msg']);
        }

        return $this->apiResponse([], 200, __('folder created successfully'));
    }

    /**
     * rename item.
     *
     * @bodyParam path string required
     * @bodyParam new_name string required
     * @bodyParam type string optional in [file, directory] default file
     * @return \Illuminate\Http\JsonResponse
     */
    public function rename(RenameItemRequest $renameItemRequest)
    {
        $result = $this->fileManagerService->renameFile($renameItemRequest);

        if (!$result['status']) {
            return $this->apiResponse([], 400, $result['msg']);
        }

        return $this->apiResponse([], 200, __('name changed successfully'));
    }

    /**
     * move files/folders.
     *
     * @bodyParam from_path string required
     * @bodyParam to_path string required
     * @bodyParam file string optional . required if type file
     * @bodyParam type string optional in [file, directory] default file
     * @bodyParam use_copy boolean optional. by default false
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(MoveRequest $moveRequest)
    {
        $result = $this->fileManagerService->moveItem($moveRequest);

        if (!$result['status']) {
            return $this->apiResponse([], 400, $result['msg']);
        }

        return $this->apiResponse([], 200, __('the file has been moved successfully'));
    }
}
