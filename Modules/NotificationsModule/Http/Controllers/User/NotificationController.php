<?php

namespace Modules\NotificationsModule\Http\Controllers\User;


use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\NotificationsModule\Entities\NotificationsCenter;
use Modules\NotificationsModule\Transformers\NotificationResource;

class NotificationController extends Controller
{
    use ApiResponseTrait;

    public function findAll()
    {
        return $this->apiResponse([
            'notifications' => new PaginateResource(NotificationResource::collection(NotificationsCenter::latest()->paginate()))
        ]);
    }
}
