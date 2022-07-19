<?php

namespace Modules\BookingModule\Http\Controllers\User;

use App\Proxy\Proxy;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\CommonModule\Traits\ApiResponseTrait;

class TestingController extends Controller
{
    use ApiResponseTrait;

    public function changeBookingStatus($bookingId, $status)
    {
        abort_if(!in_array($status, BookingStatus::getStatus()), 404);

        $booking = app(BookingRepository::class)->findByUser(auth('api')->id(), $bookingId);
        $booking->status = $status;
        if ($status == BookingStatus::ACCEPT) {
            $booking->accepted_at = now();
        }
        $booking->save();

        $entityStatus = (new Proxy(new BookingProxy('UPDATE_ENTITY_STATE', ['id' => (string)$booking->entity_id, 'state' => 'pending'])))->result();

        return $this->apiResponse([]);
    }
}
