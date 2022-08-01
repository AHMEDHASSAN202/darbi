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
                    'title'     => getLocalesWord('New Booking'),
                    'message'   => getLocalesWord('There is a new booking waiting for your approval'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds([(string)$event->booking->vendor_id])
                ];
                break;
            case BookingStatus::CANCELLED_BEFORE_ACCEPT:
                $notifications[] = [
                    'title'     => getLocalesWord('Booking canceled'),
                    'message'   => getLocalesWord('Your Booking has been canceled'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                break;
            case BookingStatus::ACCEPT:
                $notifications[] = [
                    'title'     => getLocalesWord('Booking approved'),
                    'message'   => getLocalesWord('Your Booking has been approved. Waiting for payment'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                break;
            case BookingStatus::CANCELLED_AFTER_ACCEPT:
            case BookingStatus::FORCE_CANCELLED:
                $notifications[] = [
                    'title'     => getLocalesWord('Booking canceled'),
                    'message'   => getLocalesWord('Your Booking has been canceled'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => getLocalesWord('Booking canceled'),
                    'message'   => getLocalesWord('Booking has been canceled successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds([(string)$event->booking->vendor_id])
                ];
                break;
            case BookingStatus::PAID:
                $notifications[] = [
                    'title'     => getLocalesWord('Booking paid'),
                    'message'   => getLocalesWord('Payment completed successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => getLocalesWord('Booking paid'),
                    'message'   => getLocalesWord('Payment completed successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds([(string)$event->booking->vendor_id])
                ];
                break;
            case BookingStatus::PICKED_UP:
                $notifications[] = [
                    'title'     => getLocalesWord('Picked up'),
                    'message'   => getLocalesWord('Entity received successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => getLocalesWord('Picked up'),
                    'message'   => getLocalesWord('Entity received successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds([(string)$event->booking->vendor_id])
                ];
                break;
            case BookingStatus::DROPPED:
                $notifications[] = [
                    'title'     => getLocalesWord('Dropped'),
                    'message'   => getLocalesWord('Entity dropped successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => getLocalesWord('Dropped'),
                    'message'   => getLocalesWord('Entity dropped successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds([(string)$event->booking->vendor_id])
                ];
                break;
            case BookingStatus::COMPLETED:
                $notifications[] = [
                    'title'     => getLocalesWord('Completed'),
                    'message'   => getLocalesWord('Booking completed successfully'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => getLocalesWord('Completed'),
                    'message'   => getLocalesWord('Booking completed successfully'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds([(string)$event->booking->vendor_id])
                ];
                break;
            case BookingStatus::REJECTED:
                $notifications[] = [
                    'title'     => getLocalesWord('Rejected'),
                    'message'   => getLocalesWord('Booking Rejected'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                break;
            case BookingStatus::TIMEOUT:
                $notifications[] = [
                    'title'     => getLocalesWord('Timeout'),
                    'message'   => getLocalesWord('Booking Timeout'),
                    'receivers' => [['id' => (string)$event->booking->user_id, 'type' => 'user']]
                ];
                $notifications[] = [
                    'title'     => getLocalesWord('Timeout'),
                    'message'   => getLocalesWord('Booking Timeout'),
                    'receivers' => app(BookingService::class)->getVendorAdminIds([(string)$event->booking->vendor_id])
                ];
                break;
        }

        foreach ($notifications as $notification) {
            $notificationId = app(BookingService::class)->createNotification(
                $notification['title'],
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
