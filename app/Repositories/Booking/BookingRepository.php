<?php
namespace App\Repositories\Booking;

use Exception;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;

class BookingRepository extends BaseRepository
{
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
    */
	public function create(Request $request)
	{
		try{
            $item = Item::with('location')
                        ->where([['id', $request->accommodation_id], ['availability', '>', 0]])
                        ->firstOr(function () {
                            throw new Exception('Accommodation is not available for booking', 404);            
                        });

            $item->decrement('availability', 1);

            return $this->sendSuccess('Accommodation booked successfully');

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}

}