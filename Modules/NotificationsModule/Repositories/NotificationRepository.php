<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Repositories;

use Illuminate\Http\Request;
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
        $me = auth('api')->user();

        return $this->notificationsCenter->latest()->where('receivers.user_id', new ObjectId($me->_id))->where('receivers.on_model', 'user')->paginated();
    }

    public function create($data)
    {
        return $this->notificationsCenter->create($data);
    }

    public function findAll(Request $request)
    {
        return $this->notificationsCenter->search($request)->filters($request)->latest()->paginated();
    }

    public function find($id)
    {
        return $this->notificationsCenter->findOrFail($id);
    }
}
