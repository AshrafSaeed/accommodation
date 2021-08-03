<?php

namespace App\Http\Resources;

use App\Http\Resources\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        return [
            'id' => $this->id,   
            'name' => $this->name,   
            'category' => $this->category, 
            'rating' => $this->rating, 
            'location' => (new LocationResource($this->location)), 
            'image_url' => $this->image_url, 
            'reputation' => $this->reputation, 
            'reputation_badge' => $this->badge, 
            'price' => $this->price, 
            'availability' => $this->availability, 
            'slug' => $this->slug, 
        ];    
    }
}
