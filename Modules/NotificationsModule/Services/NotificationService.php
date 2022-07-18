<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\NotificationsModule\Enums\NotificationReceiverTypes;
use Modules\NotificationsModule\Http\Requests\CreateNotificationRequest;
use Modules\NotificationsModule\Proxy\NotificationProxy;
use Modules\NotificationsModule\Repositories\NotificationRepository;
use Modules\NotificationsModule\Transformers\Admin\FindNotificationResource;
use Modules\NotificationsModule\Transformers\NotificationResource;
use MongoDB\BSON\ObjectId;
use OneSignal;

class NotificationService
{
    private $notificationRepository;

    use ImageHelperTrait;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }


    public function listOfMyNotifications($request)
    {
        $notifications = $this->notificationRepository->listOfMyNotifications($request);

        if ($notifications instanceof LengthAwarePaginator) {
            return new PaginateResource(NotificationResource::collection($notifications));
        }

        return NotificationResource::collection($notifications);
    }


    public function findAll(Request $request)
    {
        try {

            $notifications = $this->notificationRepository->findAll($request);

            if ($notifications instanceof LengthAwarePaginator) {
                return serviceResponse(['notifications' => new PaginateResource(\Modules\NotificationsModule\Transformers\Admin\NotificationResource::collection($notifications))]);
            }

            return serviceResponse(['notifications' => \Modules\NotificationsModule\Transformers\Admin\NotificationResource::collection($notifications)]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serviceResponse([], 500, __("Get notifications error"));
        }
    }


    public function find($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (!$notification) {
            helperLog(__CLASS__, __FUNCTION__, 'Notification not found');
            return serviceResponse([], 500, __("Notification not found"));
        }

        return serviceResponse(['notification' => new FindNotificationResource($notification)]);
    }


    public function sendToUsers($title, $message, $players, $subtitle = null, $url = null, $data = null, $buttons = null, $schedule = null)
    {
        try {
            OneSignal::sendNotificationToUser(
                $message,
                $players,
                $url,
                $data,
                $buttons,
                $schedule,
                $title,
                $subtitle
            );

            return serviceResponse([]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serviceResponse([], 500, __("Can't send Notifications"));
        }
    }


    public function sendToAll($title, $message, $subtitle = null, $url = null, $data = null, $buttons = null, $schedule = null)
    {
        try {

            OneSignal::sendNotificationToAll(
                $message,
                $url,
                $data,
                $buttons,
                $schedule,
                $title,
                $subtitle
            );

            return serviceResponse([]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serviceResponse([], 500, __("Can't send Notifications"));
        }
    }


    public function create(CreateNotificationRequest $createNotificationRequest)
    {
        $image = null;
        if ($createNotificationRequest->hasFile('image')) {
            $image = $this->uploadImage('notifications', $createNotificationRequest->image);
        }

        $me = auth(getCurrentGuard())->user();

        $notification = $this->notificationRepository->create([
            'title'             => $createNotificationRequest->title,
            'message'           => $createNotificationRequest->message,
            'url'               => $createNotificationRequest->url,
            'image'             => $image,
            'receivers'         => $this->getReceivers($createNotificationRequest),
            'notification_type' => $createNotificationRequest->notification_type,
            'receiver_type'     => $createNotificationRequest->receiver_type,
            'extra_data'        => $createNotificationRequest->extra_data ?? [],
            'triggered_by'      => [
                'is_automatic'       => !($createNotificationRequest->is_automatic === null) && (boolean)$createNotificationRequest->is_automatic,
                'user_id'            => $me->id,
                'on_model'           => get_class($me)
            ]
        ]);

        if (!$notification) {
            helperLog(__CLASS__, __FUNCTION__, 'Unable to create new notification');
            return serviceResponse([], 500, __("Unable to create new notification"));
        }

        return serviceResponse(['id' => $notification->id], 201, __('Data has been added successfully'));
    }


    private function getReceivers(Request $request)
    {
        $receivers = [];

        if ($request->receiver_type == NotificationReceiverTypes::SPECIFIED) {
            $receivers = array_map(function ($receiver) { return ['user_id' => new ObjectId($receiver['id']), 'on_model' => $receiver['type']]; }, $request->receivers);
        }

        return $receivers;
    }


    private function getUserReceivers()
    {
        $notificationProxy = new NotificationProxy('GET_USERS');
        $proxy = new Proxy($notificationProxy);
        $users = $proxy->result() ?? [];
        return array_map(function ($user) { return ['user_id' => new ObjectId($user['id']), 'on_model' => 'user']; }, $users);
    }


    private function getVendorAdminIds($vendorId)
    {
        $notificationProxy = new NotificationProxy('GET_VENDOR_ADMINS_IDS', ['type' => 'vendor', 'vendor' => $vendorId]);
        $proxy = new Proxy($notificationProxy);
        $adminVendors = $proxy->result() ?? [];
        return array_map(function ($admin) { return ['id' => new ObjectId($admin['id']), 'type' => 'admin']; }, $adminVendors);
    }
}
