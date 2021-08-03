<?php
namespace App\Repositories\Item;

use Auth,Exception;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Transformers\ItemTransformer as Transform;
use App\Http\Resources\ItemResource;

class ItemRepository extends BaseRepository
{

    /**
     * get accommodation list
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ItemResource|\Illuminate\Http\JsonResponse
    */
	public function list(Request $request, $by_user = true)
	{	        
		try{
            $items = Item::with('location')
                ->when($by_user, function ($query, $by_user) {
                    return $query->whereUserId(Auth::id());
                })
                ->filter($request)
                ->orderBy('items.id', 'DESC')
                ->paginate(10);

            return ItemResource::collection($items);

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}

    /**
     * create new accommodation
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
    */
	public function create(Request $request)
	{
		try{
            $Item = Item::create(Transform::item($request));
            $Item->location()->create(Transform::location($request));            
            return $this->sendResponse((new ItemResource($Item)), 'Accommodation created successfully');

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}

    /**
     * get single accommodation
     * 
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
    */
	public function read($id)
	{
		try{
            $Item = $this->getItem($id);
            return $this->sendResponse((new ItemResource($Item)), '');

        } catch (Exception $e) {    
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}


    /**
     * get single accommodation by slug
     * 
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
    */
    public function get($slug)
    {
        try{
            $Item = Item::with('location')
                            ->whereSlug($slug)->firstOr(function () {
                                throw new Exception('This accommodation not found', 404);            
                            });

            return $this->sendResponse((new ItemResource($Item)), '');

        } catch (Exception $e) {    
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
    }

    /**
     * update accommodation
     * 
     * @param \Illuminate\Http\Request $request
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
    */
	public function update(Request $request, $id)
	{
		try{
            if (count($request->all()) < 1) {
                throw new Exception('There is no date in payload', 422);
            }

            $item = $this->getItem($id);
            $item->update(Transform::item($request));

            if($request->has('location')) {
                $item->location()->update(Transform::location($request));
            }

            if(!$item) {
                throw new Exception('There is some problem ,contact site administrater', 404);
            }

            $item = Item::with('location')->find($id);
            
            return $this->sendResponse(new ItemResource($item), 'Accommodation updated successfully');

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}

    /*
     * delete accommodation
     *
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
	*/
    public function delete($id)
	{
		try{
            $Item = $this->getItem($id);
        	$Item->location()->delete();
        	$Item->delete();
            
            return $this->sendSuccess('Accommodation deleted successfully');       

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}


    /*
     * Reterive accommodation from database 
     *
     * @param Int $id
     * @return App\Models\Item Item
    */
    protected function getItem($id) {
        
        return Item::with('location')
                            ->whereUserId(Auth::id())
                            ->whereId($id)->firstOr(function () {
                                throw new Exception('This accommodation is not associated with current user', 403);            
                            });
    }

    // 403 Forbidden
    // The client does not have access rights to the content; that is, it is unauthorized, so the server is refusing to give the requested resource. Unlike 401, the client's identity is known to the server.

    // 406 Not Acceptable
    // This response is sent when the web server, after performing server-driven content negotiation, doesn't find any content that conforms to the criteria given by the user agent.

}