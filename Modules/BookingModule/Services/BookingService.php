<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\BookingModule\Classes\BookingChangeLog;
use Modules\BookingModule\Classes\EntityAreas\Area;
use Modules\BookingModule\Classes\Payments\Payment;
use Modules\BookingModule\Classes\Price;
use Modules\BookingModule\Classes\Validation\BookingDateValidation;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Http\Requests\AddBookDetailsRequest;
use Modules\BookingModule\Http\Requests\ProceedRequest;
use Modules\BookingModule\Http\Requests\RentRequest;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\BookingModule\Transformers\FindBookingResource;
use Modules\BookingModule\Transformers\BookingResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class BookingService
{
    use BookingHelperService;

    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }


    public function findAllByAuth(Request $request)
    {
        $userId = auth('api')->id();

        $bookings = $this->bookingRepository->findAllByUser($userId, $request);

        if ($bookings instanceof LengthAwarePaginator) {
            return successResponse(['bookings' => new PaginateResource(BookingResource::collection($bookings))]);
        }

        return successResponse(['bookings' => BookingResource::collection($bookings)]);
    }


    public function findByAuth($bookingId)
    {
        $userId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($userId, $bookingId);

        return successResponse(['booking' => new FindBookingResource($booking)]);
    }


    public function rent(RentRequest $rentRequest)
    {
        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $rentRequest->entity_id])))->result();

        abort_if(is_null($entity), 404);

        $vendor = (new Proxy(new BookingProxy('GET_VENDOR', ['vendor_id' => $entity['vendor_id']])))->result();

        $city = (new Proxy(new BookingProxy('GET_CITY', ['city_id' => $rentRequest->city_id])))->result();

        abort_if((is_null($vendor) || is_null($city)), 404);

        $rentValidation = $this->rentValidation($entity, $vendor);

        if ($rentValidation !== true) {
            return $rentValidation;
        }

        $extras = $this->getExtras($entity, $rentRequest->extras);
        $country = $entity['country'];

        if (!entityIsVilla($entity['type'])) {
            $area = new Area($entity);

            $entityArea = $area->getDetails();

            if (empty($entityArea)) {
                return badResponse([], $area->getError());
            }
        }

        $booking = $this->bookingRepository->create([
            'user_id'       => new ObjectId(auth('api')->id()),
            'user'          => auth('api')->user()->only(['_id', 'phone', 'phone_code', 'name', 'email']),
            'vendor'        => $vendor,
            'vendor_id'     => new ObjectId($entity['vendor_id']),
            'area_id'       => isset($entityArea) ? new ObjectId($entityArea['id']) : null,
            'area'          => $entityArea ?? null,
            'entity_id'     => new ObjectId($entity['id']),
            'entity_type'   => arrayGet($entity, 'entity_type'),
            'entity_details' => [
                'name'      => arrayGet($entity, 'name', ''),
                'price'     => arrayGet($entity, 'price'),
                'price_unit'=> arrayGet($entity, 'price_unit'),
                'images'    => arrayGet($entity, 'images'),
                'model_id'  => (isset($entity['model_id']) && !empty($entity['model_id'])) ? new ObjectId($entity['model_id']) : null,
                'model_name'=> arrayGet($entity, 'model_name'),
                'brand_id'  => (isset($entity['model_id']) && !empty($entity['model_id'])) ? new ObjectId($entity['brand_id']) : null,
                'brand_name'=> arrayGet($entity, 'brand_name'),
            ],
            'country_id'    => new ObjectId($country['_id']),
            'country'       => $country,
            'currency_code' => $country['currency_code'],
            'city_id'       => new ObjectId($city['id']),
            'city'          => $city,
            'status'        => BookingStatus::INIT,
            'extras'        => $extras,
            'start_booking_at' => $rentRequest->start_at,
            'end_booking_at'   => $rentRequest->end_at
        ]);

        return createdResponse(['booking_id' => $booking->id]);
    }


    private function getExtras($entity, $extras) : array
    {
        $entityExtras = arrayGet($entity, 'extras');

        if (!is_array($extras) || empty($extras) || empty($entity) || !is_array($entityExtras)) return [];

        $bookingExtras = [];

        foreach ($entityExtras as $entityExtra) {
            if (in_array($entityExtra['id']['$oid'], $extras)) {
                $bookingExtras[] = $entityExtra;
            }
        }

        return $bookingExtras;
    }


    public function addBookDetails($bookingId, AddBookDetailsRequest $addBookDetailsRequest)
    {
        $me = auth('api')->user();

        if (!$me->is_profile_completed) {
            return badResponse([], __('Please complete your profile first'));
        }

        $booking = $this->bookingRepository->findByUser($me->id, $bookingId);

        abort_if((is_null($booking) || $booking->status != BookingStatus::INIT), 404);

        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $booking->entity_id])))->result();
        $vendor = (new Proxy(new BookingProxy('GET_VENDOR', ['vendor_id' => $entity['vendor_id']])))->result();

        abort_if(is_null($entity) || is_null($vendor), 404);

        $startDate = $addBookDetailsRequest->start_at;
        $endDate = getBookingEndDate($entity['price_unit'], $addBookDetailsRequest->start_at, $addBookDetailsRequest->end_at);

        $rentValidation = $this->rentValidation($entity, $vendor, $startDate, $endDate);

        if ($rentValidation !== true) {
            return $rentValidation;
        }

        $dateValidation = (new BookingDateValidation($entity))->validator($addBookDetailsRequest);

        if (!$dateValidation->passes()) {
            return badResponse([], $dateValidation->error());
        }

        $priceSummary = (new Price($entity, $booking->extras, $startDate, $endDate, $booking->vendor))->getPriceSummary();
        $this->bookingRepository->update($bookingId, [
            'user'                          => auth('api')->user()->only(['_id', 'phone', 'phone_code', 'name', 'email']),
            'price_summary'                 => $priceSummary,
            'pickup_location_address'       => is_array($entity['location'] ?? $addBookDetailsRequest->pickup_location) ? Arr::only($entity['location'] ?? $addBookDetailsRequest->pickup_location, [...locationInfoKeys()]) : null,
            'drop_location_address'         => is_array($addBookDetailsRequest->pickup_location) ? Arr::only($addBookDetailsRequest->drop_location, [...locationInfoKeys()]) : null,
            'status_change_log'             => (new BookingChangeLog($booking, BookingStatus::PENDING, $me))->logs(),
            'status'                        => BookingStatus::PENDING,
            'start_booking_at'              => convertDateTimeToUTC($me, $startDate),
            'end_booking_at'                => convertDateTimeToUTC($me, $endDate),
            'pending_at'                    => new \MongoDB\BSON\UTCDateTime(),
            'note'                          => $addBookDetailsRequest->note
        ]);

        $booking->refresh();

        event(new BookingStatusChangedEvent($booking));

        return successResponse();
    }


    public function cancel($bookingId)
    {
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($me->id, $bookingId);

        if (!in_array($booking->status, [BookingStatus::INIT, BookingStatus::PENDING, BookingStatus::ACCEPT])) {
            return badResponse([], __('booking not allowed', ['status' => __('cancel')]));
        }

        $session = DB::connection('mongodb')->getMongoClient()->startSession();
        $session->startTransaction();

        try {

            $cancelledBeforeAccept = ($booking->status === BookingStatus::ACCEPT) ? BookingStatus::CANCELLED_AFTER_ACCEPT: BookingStatus::CANCELLED_BEFORE_ACCEPT;
            $data = [
                'status_change_log'     => (new BookingChangeLog($booking, $cancelledBeforeAccept, $me))->logs(),
                'status'                => $cancelledBeforeAccept
            ];

            $this->bookingRepository->updateBookingCollection($bookingId, $data, $session);

            $this->updateEntityState($cancelledBeforeAccept, $booking);

            $session->commitTransaction();

            $booking->refresh();

            event(new BookingStatusChangedEvent($booking));

            return successResponse(['booking_id' => $bookingId]);

        }catch (\Exception $exception) {
            $session->abortTransaction();
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serverErrorResponse();
        }
    }


    public function proceed($bookingId, ProceedRequest $proceedRequest)
    {
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($me->id, $bookingId);

        if ($booking->status != BookingStatus::ACCEPT) {
            return badResponse([], __('booking not allowed', ['status' => __('proceed')]));
        }

        $payment = new Payment($proceedRequest->payment_method, $proceedRequest->all());

        $data['payment_method'] = [
            'type'       => $proceedRequest->payment_method,
            'extra_info' => $payment->storeData()
        ];

        if (!$payment->successTransaction()) {
            $this->bookingRepository->update($bookingId, $data);

            helperLog(__CLASS__, __FUNCTION__, 'Payment Failed');

            return badResponse([], __('Payment Failed'));
        }

        $data['status'] = BookingStatus::PAID;
        $data['status_change_log'] = (new BookingChangeLog($booking, BookingStatus::PAID, $me))->logs();

        $this->bookingRepository->update($bookingId, $data);

        $booking->refresh();

        event(new BookingStatusChangedEvent($booking));

        return successResponse([], __('Payment Successful'));
    }


    public function updateBookingsTimeout()
    {
        $bookings = $this->bookingRepository->getTimeoutBookings();
        $bookingTimeoutState = BookingStatus::TIMEOUT;

        foreach ($bookings as $booking) {
            try {

                $this->bookingRepository->update($booking->id, [
                    'status'    => $bookingTimeoutState,
                    'status_change_log' => (new BookingChangeLog($booking, $bookingTimeoutState))->logs()
                ]);

                $booking->refresh();

                $this->updateEntityState($bookingTimeoutState, $booking);

                event(new BookingStatusChangedEvent($booking));

            }catch (\Exception $exception) {
                helperLog(__CLASS__, __FUNCTION__, $exception->getMessage(), $booking->toArray());
            }
        }

        return successResponse();
    }


    public function reminderBookings()
    {
        $bookings = $this->bookingRepository->getReminderBookings();

        foreach ($bookings as $booking) {

            if ($booking->status === BookingStatus::PAID) {

                //notification to user
                $this->createNotification(
                    'Reminder',
                    'Booking Reminder Picked up',
                    [['id' => new ObjectId($booking->user_id), 'type' => 'user']],
                    $booking->id
                );

                //notification to vendor admins
                $vendorAdminIds = $this->getVendorAdminIds((string)$booking->vendor_id);
                $this->createNotification(
                    'Reminder',
                    'Booking Reminder Picked up',
                    $vendorAdminIds,
                    $booking->id
                );

            }elseif ($booking->status === BookingStatus::PICKED_UP) {

                //notification to user
                $this->createNotification(
                    'Reminder',
                    'Booking Reminder Dropped',
                    [['id' => new ObjectId($booking->user_id), 'type' => 'user']],
                    $booking->id
                );

                //notification to vendor admin
                $vendorAdminIds = $this->getVendorAdminIds((string)$booking->vendor_id);
                $this->createNotification(
                    'Reminder',
                    'Booking Reminder Dropped',
                    $vendorAdminIds,
                    $booking->id
                );

            }
        }

        return successResponse();
    }


    public function createNotification(string $title, string $message, array $receivers, $bookingId)
    {
        $bookingProxy = new BookingProxy('CREATE_NOTIFICATION', [
            'title'             => $title,
            'message'           => $message,
            'notification_type' => 'booking',
            'receiver_type'     => 'specified',
            'receivers'         => $receivers,
            'extra_data'        => ['booking_id' => $bookingId],
            'is_automatic'      => true,
        ]);

        $proxy = new Proxy($bookingProxy);

        return $proxy->result();
    }


    public function getVendorAdminIds($vendorId)
    {
        $notificationProxy = new BookingProxy('GET_VENDOR_ADMINS_IDS', ['type' => 'vendor', 'vendor' => $vendorId]);
        $proxy = new Proxy($notificationProxy);
        $adminVendors = $proxy->result() ?? [];
        return array_map(function ($admin) { return ['user_id' => new ObjectId($admin['id']), 'on_model' => 'admin']; }, $adminVendors);
    }


    private function rentValidation($entity, $vendor, $startDate = null, $endDate = null)
    {
        if (!entityIsFree($entity['state'])) {
            //check if entity have booking in the same time
            if ($startDate && $endDate) {
                if ($this->bookingRepository->checkIfEntityHaveBooking($entity['id'], $startDate, $endDate)) {
                    return badResponse([], __('Booking not allowed now'));
                }
            }
        }

        if ($vendor['is_active'] !== true) {
            return badResponse([], __('Vendor is not active now'));
        }

        if ($this->bookingRepository->checkIfIHaveBookingsNow($entity['id'])) {
            return badResponse([], __('Sorry, you have a booking pending approval'));
        }

        return true;
    }
}
