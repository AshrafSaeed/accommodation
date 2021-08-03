<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Repositories\Booking\BookingRepository;

class BookingController extends Controller
{
    /**
     * @var \App\Repositories\Booking\BookingRepository
     */
    private $booking;

    /**
     * @param \App\Repositories\Booking\BookingRepository $bookingrepo
     *
     */
    public function __construct(BookingRepository $bookingrepo) {
        $this->booking = $bookingrepo;
    }

    /**
     * Create a newly booking in storage.
     *
     * @param  \App\Http\Requests\BookingRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(BookingRequest $request)
    {
        return $this->booking->create($request);
    }
}
