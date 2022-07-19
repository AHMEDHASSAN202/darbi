<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services\Admin;


use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\BookingModule\Classes\BookingChangeLog;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\BookingModule\Transformers\Admin\BookingResource;
use Modules\BookingModule\Transformers\Admin\FindBookingResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class BookingService
{
    private $bookingRepository;


    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }


    public function acceptByVendor($bookingId)
    {
        return $this->changeBookingStatus($bookingId, BookingStatus::ACCEPT, [BookingStatus::PENDING]);
    }


    public function cancelByVendor($bookingId)
    {
        return $this->changeBookingStatus($bookingId, null, [BookingStatus::PENDING, BookingStatus::ACCEPT], function ($booking) {
            return  ($booking->status == BookingStatus::ACCEPT) ? BookingStatus::CANCELLED_AFTER_ACCEPT : BookingStatus::REJECTED;
        });
    }


    public function getBookingsByVendor(Request $request)
    {
        $vendorId = new ObjectId(getVendorId());

        $bookings = $this->bookingRepository->bookingsByVendor($vendorId, $request);

        if ($bookings instanceof LengthAwarePaginator) {
            return successResponse(['bookings' => new PaginateResource(BookingResource::collection($bookings))]);
        }

        return successResponse(['bookings' => BookingResource::collection($bookings)]);
    }


    public function findAll(Request $request)
    {
        $bookings = $this->bookingRepository->findAll($request);

        if ($bookings instanceof LengthAwarePaginator) {
            return successResponse(['bookings' => new PaginateResource(BookingResource::collection($bookings))]);
        }

        return successResponse(['bookings' => BookingResource::collection($bookings)]);
    }


    public function find($bookingId)
    {
        $booking = $this->bookingRepository->findByAdmin(new ObjectId($bookingId));

        return successResponse(['booking' => new FindBookingResource($booking)]);
    }


    public function findBookingByVendor($bookingId)
    {
        $vendorId = new ObjectId(getVendorId());

        $booking = $this->bookingRepository->findByVendor($vendorId, new ObjectId($bookingId));

        return successResponse(['booking' => new FindBookingResource($booking)]);
    }


    public function vendorSales()
    {
        $vendorId = new ObjectId(getVendorId());

        return $this->bookingRepository->vendorSales($vendorId);
    }


    public function vendorOrders()
    {
        $vendorId = new ObjectId(getVendorId());

        return $this->bookingRepository->vendorOrders($vendorId);
    }


    public function cancelByAdmin($bookingId)
    {
        return $this->changeBookingStatus($bookingId, BookingStatus::FORCE_CANCELLED, [BookingStatus::PENDING, BookingStatus::ACCEPT, BookingStatus::PAID]);
    }


    public function paidByVendor($bookingId)
    {
        return $this->changeBookingStatus($bookingId, BookingStatus::PAID, [BookingStatus::ACCEPT]);
    }


    public function completeByVendor($bookingId)
    {
        return $this->changeBookingStatus($bookingId, BookingStatus::COMPLETED, [BookingStatus::DROPPED, BookingStatus::PICKED_UP]);
    }


    private function changeBookingStatus($bookingId, $status, array $allowedStatus = [], $handleNewStatus = null)
    {
        $session = DB::connection('mongodb')->getMongoClient()->startSession();
        $session->startTransaction();

        try {

            $booking = $this->bookingRepository->findByAdmin(new ObjectId($bookingId));

            abort_if(is_null($booking), 404);

            if (!in_array($booking->status, $allowedStatus)) {
                return badResponse([], __('booking not allowed', ['status' => __($status)]));
            }

            $data['status'] = $handleNewStatus ? $handleNewStatus($booking) : $status;
            $data['status_change_log'] = (new BookingChangeLog($booking, $status, auth(getCurrentGuard())->user()))->logs();
            $this->bookingRepository->updateBookingCollection($bookingId, $data, $session);

            $booking->refresh();

            event(new BookingStatusChangedEvent($booking));

            $session->commitTransaction();

            return successResponse(['booking_id' => $bookingId]);

        } catch (\Exception $exception) {
            $session->abortTransaction();
            dd($exception);
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serverErrorResponse();
        }
    }
}
