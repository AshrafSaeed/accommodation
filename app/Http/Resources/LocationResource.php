<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'address' => $this->address,   
            'city' => $this->city,   
            'state' => $this->state, 
            'zip_code' => $this->zip_code, 
            'country' => $this->country, 
        ];    
    }
}
