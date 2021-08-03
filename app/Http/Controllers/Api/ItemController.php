<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\{ ItemRequest, ItemUpdateRequest };
use App\Repositories\Item\ItemRepository;

class ItemController extends Controller
{
    /**
     * @var \App\Repositories\Item\ItemRepository
     */
    private $item;

    /**
     * @param \App\Repositories\Item\ItemRepository $itemrepo
     *
     */
    public function __construct(ItemRepository $itemrepo) {
        $this->item = $itemrepo;
    }

    /**
     * Display a listing of the Item.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ItemCollecion
     */
    public function index(Request $request)
    {
        return $this->item->list($request);
    }

    /**
     * Store a newly created Item in storage.
     *
     * @param  \App\Http\Requests\ItemRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ItemRequest $request)
    {
        return $this->item->create($request);
    }

    /**
     * Display the specified Item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->item->read($id);
    }

    /**
     * Update the specified Item in storage.
     *
     * @param  \App\Http\Requests\ItemUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ItemUpdateRequest $request, $id)
    {
        return $this->item->update($request, $id);
    }

    /**
     * Remove the specified Item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->item->delete($id);
    }

    /**
     * Display all Items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ItemCollecion
     */
    public function list(Request $request)
    {
        return $this->item->list($request, false);
    }

     /**
     * Get Single Accomodations by Slug.
     * 
     * @param  string $slug
     * @return \App\Http\Resources\ItemCollecion
     */
    public function get($slug)
    {
        return $this->item->get($slug);
    }

    
   
}
