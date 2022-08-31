<?php

namespace Modules\CatalogModule\Http\Controllers\Web;


use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\SettingService;

class PrivateJetController extends Controller
{
    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function __invoke()
    {
        $privateJetInfo = optional($this->settingService->getSettings())->private_jets_info;

        return view('catalogmodule::pages.private-jets', compact('privateJetInfo'));
    }
}
