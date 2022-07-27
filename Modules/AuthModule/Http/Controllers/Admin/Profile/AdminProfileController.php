<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Profile;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\UpdateAdminProfile;
use Modules\AuthModule\Services\AdminProfileService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function __;


class AdminProfileController extends Controller
{
    use ApiResponseTrait;

    private $adminProfileService;

    public function __construct(AdminProfileService $adminProfileService)
    {
        $this->adminProfileService = $adminProfileService;
    }


    public function getProfile()
    {
        $result = $this->adminProfileService->getProfile();

        return $this->apiResponse(...$result);
    }


    public function updateProfile(UpdateAdminProfile $updateAdminProfile)
    {
        $result = $this->adminProfileService->updateProfile($updateAdminProfile);

        return $this->apiResponse(...$result);
    }
}
