<?php

namespace Modules\BookingModule\Http\Controllers\Web;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Http\Requests\Web\CreateReservationRequest;
use Modules\BookingModule\Services\ReservationService;

class ReservationController extends Controller
{
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function store(CreateReservationRequest $createReservationRequest)
    {
        $created = $this->reservationService->store($createReservationRequest);

        if (!$created) {
            return redirect()->back()->with('errmsg', __('reservation.msg_store_error'));
        }

        return redirect()->back()->with('msg', __('reservation.msg_store_success'));
    }
}
