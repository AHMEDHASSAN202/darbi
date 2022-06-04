<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Modules\BookingModule\Http\Requests\RentRequest;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\BookingModule\Transformers\BookingResource;
use Modules\CommonModule\Transformers\PaginateResource;

class BookingService
{
    private $bookingRepository;


    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }


    public function findAllByAuth(Request $request)
    {
        $userId = auth('api')->id();

        $bookings = $this->bookingRepository->findAllByUser($userId, $request->get('limit', 20));

        return new PaginateResource(BookingResource::collection($bookings));
    }


    public function findByAuth($bookingId)
    {
        $userId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($userId, $bookingId);

        return new BookingResource($booking);
    }


    public function rent(RentRequest $rentRequest)
    {
        $car = (new Proxy(new BookingProxy('GET_CAR', ['entity_id' => $rentRequest->entity_id])))->result();

        abort_if(is_null($car), 404);

        dd($car);
    }

}
