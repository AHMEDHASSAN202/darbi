<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Repositories;

use Modules\NotificationsModule\Entities\NotificationsCenter;
use MongoDB\BSON\ObjectId;

class NotificationRepository
{
    private $notificationsCenter;

    public function __construct(NotificationsCenter $notificationsCenter)
    {
        $this->notificationsCenter = $notificationsCenter;
    }

    public function listOfMyNotifications($request)
    {
        $me = auth()->user();

        //->where('receiver.user_id', new ObjectId($me->_id))->where('receiver.on_model', 'user')
        return $this->notificationsCenter->latest()->paginate($request->get('limit', 20));
    }
}
