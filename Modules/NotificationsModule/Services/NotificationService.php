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
            return successResponse(['notifications' => new PaginateResource(NotificationResource::collection($notifications))]);
        }

        return successResponse(['notifications' => NotificationResource::collection($notifications)]);
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
        $receivers = $this->getReceivers($createNotificationRequest);

        $receiversParts = array_chunk($receivers, 500);

        if(empty($receiversParts)) {
            $receiversParts[] = [];
        }

        foreach ($receiversParts as $receiversPart) {
            $notification = $this->notificationRepository->create([
                'title'             => $createNotificationRequest->title,
                'message'           => $createNotificationRequest->message,
                'url'               => $createNotificationRequest->url,
                'image'             => $image,
                'receivers'         => $receiversPart,
                'notification_type' => $createNotificationRequest->notification_type,
                'receiver_type'     => $createNotificationRequest->receiver_type,
                'extra_data'        => $createNotificationRequest->extra_data ?? [],
                'triggered_by'      => [
                    'is_automatic'       => !($createNotificationRequest->is_automatic === null) && (boolean)$createNotificationRequest->is_automatic,
                    'user_id'            => optional($me)->id,
                    'on_model'           => $me ? get_class($me) : null
                ]
            ]);

            if (!$notification) {
                helperLog(__CLASS__, __FUNCTION__, 'Unable to create new notification');
                return serviceResponse([], 500, __("Unable to create new notification"));
            }
        }

        return serviceResponse(['id' => isset($notification) ? $notification->id : null], 201, __('Data has been added successfully'));
    }


    private function getReceivers(Request $request)
    {
        $receivers = [];

        if ($request->receiver_type == NotificationReceiverTypes::SPECIFIED) {
            if ($request->hasFile('receivers_file')) {
                $receivers = $this->getUserReceiversFromExcelFile($request->receivers_file);
            }else {
                $receivers = array_map(function ($receiver) { return ['user_id' => new ObjectId($receiver['id']), 'on_model' => $receiver['type']]; }, $request->receivers);
            }
        }

        return $receivers;
    }


    private function getUserReceiversFromExcelFile($file)
    {
        $notificationProxy = new NotificationProxy('GET_USERS', ['users_file' => $file]);
        $proxy = new Proxy($notificationProxy);
        $users = $proxy->result() ?? [];
        return array_map(function ($user) { return ['user_id' => new ObjectId($user['id']), 'on_model' => 'user']; }, $users);
    }


    public function getVendorAdminIds($vendorId)
    {
        $notificationProxy = new NotificationProxy('GET_VENDOR_ADMINS_IDS', ['type' => 'vendor', 'vendor' => $vendorId]);
        $proxy = new Proxy($notificationProxy);
        $adminVendors = $proxy->result() ?? [];
        return array_map(function ($admin) { return ['id' => new ObjectId($admin['id']), 'type' => 'admin']; }, $adminVendors);
    }
}
