<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Modules\BookingModule\Classes\Price;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Http\Requests\AddBookDetailsRequest;
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
        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $rentRequest->entity_id])))->result();

        abort_if(is_null($entity), 404);

        if (!entityIsFree($entity['state'])) {
            return [
                'statusCode'    => 400,
                'data'          => [],
                'message'       => __('booking not allowed')
            ];
        }

        $plugins = $this->getPlugins($entity, $rentRequest->plugins);

        $priceSummary = (new Price($entity, $plugins))->getPriceSummary();

        $booking = $this->bookingRepository->create([
            'vendor_id'     => @$entity['vendor_id'],
            'branch_id'     => @$entity['branch_id'],
            'city_id'       => @$entity['city_id'],
            'entity_id'     => @$entity['id'],
            'entity_type'   => @$entity['entity_type'],
            'entity_details' => [
                'name'      => @$entity['name'],
                'price'     => @$entity['price'],
                'price_unit'=> @$entity['price_unit'],
                'images'    => @$entity['images'],
                'model_id'  => @$entity['model_id'],
                'model_name'=> @$entity['model_name'],
                'brand_id'  => @$entity['brand_id'],
                'brand_name'=> @$entity['brand_name'],
                'country'   => @$entity['country'],
                'city'      => @$entity['city'],
            ],
            'status'        => BookingStatus::INIT,
            'plugins'       => $plugins,
            'price_summary' => $priceSummary
        ]);

        return [
            'statusCode'    => 201,
            'message'       => '',
            'data'          => [
                'booking_id'    => $booking->_id
            ]
        ];
    }


    private function getPlugins($entity, $plugins) : array
    {
        $entityPlugins = @$entity['plugins'];

        if (!is_array($plugins) || empty($plugins) || empty($entity) || !is_array($entityPlugins)) return [];

        $bookingPlugins = [];

        foreach ($entityPlugins as $entityPlugin) {
            if (in_array($entityPlugin['id'], $plugins)) {
                $bookingPlugins[] = $entityPlugin;
            }
        }

        return $bookingPlugins;
    }


    public function addBookDetails($bookingId, AddBookDetailsRequest $addBookDetailsRequest)
    {
        $meId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        abort_if(is_null($booking), 404);

        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $booking->entity_id])))->result();

        abort_if(is_null($entity), 404);

        if (!entityIsFree($entity['state'])) {
            return [
                'statusCode'    => 400,
                'data'          => [],
                'message'       => __('booking not allowed')
            ];
        }

        $pickupLocationAddress = [
            'lat'       => $addBookDetailsRequest->pickup_location->lat,
            'lng'       => $addBookDetailsRequest->pickup_location->lng,
            'fully_addressed' => '',
            'city'          => '',
            'country'       => '',
            'state'         => '',
            'region_id'     => $addBookDetailsRequest->pickup_location->region_id,
        ];
        $dropLocationAddress = [
            'lat'       => $addBookDetailsRequest->drop_location->lat,
            'lng'       => $addBookDetailsRequest->drop_location->lat,
            'fully_addressed' => '',
            'city'          => '',
            'country'       => '',
            'state'         => '',
            'region_id'     => $addBookDetailsRequest->drop_location->region_id,
        ];

        $booking->start_booking_at = $addBookDetailsRequest->start_at;
        $booking->end_booking_at = $addBookDetailsRequest->end_at;
        $booking->pickup_location_address = $pickupLocationAddress;
        $booking->drop_location_address = $dropLocationAddress;
        $booking->status = BookingStatus::PENDING;
        $booking->save();

        return [
            'data'          => [],
            'message'       => '',
            'statusCode'    => 200
        ];
    }
}
