<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;
use Modules\AdminModule\Entities\Admin;
use Modules\CommonModule\Repositories\ActivityRepository;

class ActivityService
{
    private $activityRepository;


    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function getAdminActivities($id, $paginate = 20)
    {
        return $this->activityRepository->getActivities($id, Admin::class, $paginate);
    }
}
