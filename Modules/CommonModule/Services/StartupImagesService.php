<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Modules\CommonModule\Repositories\StartUpImageRepository;
use Modules\CommonModule\Transformers\StartUpImageResource;

class StartupImagesService
{
    private $startUpImageRepository;

    public function __construct(StartUpImageRepository $startUpImageRepository)
    {
        $this->startUpImageRepository = $startUpImageRepository;
    }

    public function getStartUpImages(Request $request)
    {
        $startUpImages = $this->startUpImageRepository->list($request->get('limit'));

        return StartUpImageResource::collection($startUpImages);
    }
}
