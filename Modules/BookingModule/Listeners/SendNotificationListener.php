<?php

namespace Modules\BookingModule\Listeners;

use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Services\BookingService;

class SendNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param BookingStatusChangedEvent $event
     * @return void
     */
    public function handle(BookingStatusChangedEvent $event)
    {
        $notifications = [];

        switch ($event->booking->status) {
            case BookingStatus::PENDING:
                $notifications[] = [
                    'title'     => __('New Booking'),
                    'message'   => __('There is a new booking waiting for your approval'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds((string)$event->booking->vendor_id)
                ];
                break;
            case BookingStatus::CANCELLED_BEFORE_ACCEPT:
                $notifications[] = [
                    'title'     => __('Booking canceled'),
                    'message'   => __('Your Booking has been canceled'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                break;
            case BookingStatus::ACCEPT:
                $notifications[] = [
                    'title'     => __('Booking approved'),
                    'message'   => __('Your Booking has been approved. Waiting for payment'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                break;
            case BookingStatus::CANCELLED_AFTER_ACCEPT:
            case BookingStatus::FORCE_CANCELLED:
                $notifications[] = [
                    'title'     => __('Booking canceled'),
                    'message'   => __('Your Booking has been canceled'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => __('Booking canceled'),
                    'message'   => __('Booking has been canceled successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds((string)$event->booking->vendor_id)
                ];
                break;
            case BookingStatus::PAID:
                $notifications[] = [
                    'title'     => __('Booking paid'),
                    'message'   => __('Payment completed successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => __('Booking paid'),
                    'message'   => __('Payment completed successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds((string)$event->booking->vendor_id)
                ];
                break;
            case BookingStatus::PICKED_UP:
                $notifications[] = [
                    'title'     => __('Picked up'),
                    'message'   => __('Entity received successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => __('Picked up'),
                    'message'   => __('Entity received successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds((string)$event->booking->vendor_id)
                ];
                break;
            case BookingStatus::DROPPED:
                $notifications[] = [
                    'title'     => __('Dropped'),
                    'message'   => __('Entity dropped successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => __('Dropped'),
                    'message'   => __('Entity dropped successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds((string)$event->booking->vendor_id)
                ];
                break;
            case BookingStatus::COMPLETED:
                $notifications[] = [
                    'title'     => __('Completed'),
                    'message'   => __('Booking completed successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => __('Completed'),
                    'message'   => __('Booking completed successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds((string)$event->booking->vendor_id)
                ];
                break;
            case BookingStatus::REJECTED:
                $notifications[] = [
                    'title'     => __('Rejected'),
                    'message'   => __('Booking Rejected'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                break;
            case BookingStatus::TIMEOUT:
                $notifications[] = [
                    'title'     => __('Timeout'),
                    'message'   => __('Booking Timeout'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => __('Timeout'),
                    'message'   => __('Booking Timeout'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds((string)$event->booking->vendor_id)
                ];
                break;
        }
        foreach ($notifications as $notification) {
            $notificationId = app(BookingService::class)->createNotification(
                $notification['title'] . ($event->booking->booking_number ? ' #' . $event->booking->booking_number : ''),
                $notification['message'],
                $notification['receivers'],
                $event->booking->id
            );

            if (!$notificationId) {
                helperLog(__CLASS__, __FUNCTION__, "Can't create notification", $notification);
            }
        }
    }
}
