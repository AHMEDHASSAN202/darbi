<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\YachtRepository;
use Modules\CatalogModule\Transformers\FindYachtResource;
use Modules\CatalogModule\Transformers\YachtResource;
use Modules\CommonModule\Services\SettingService;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class PrivateJetService
{
    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function getInfo()
    {
        $privateJetsInfo = optional($this->settingService->getSettings())->private_jets_info ?? [];
        $images = isset($privateJetsInfo['images']) ? array_map(function ($image) { return imageUrl($image, 'original'); }, $privateJetsInfo['images']) : [];

        return [
            'images'       => array_values($images),
            'title'        => translateAttribute($privateJetsInfo['title'] ?? ''),
            'desc'         => translateAttribute($privateJetsInfo['desc'] ?? ''),
            'phone'        => $privateJetsInfo['phone'] ?? '',
            'whatsapp'     => $privateJetsInfo['whatsapp'] ?? ''
        ];
    }


}
