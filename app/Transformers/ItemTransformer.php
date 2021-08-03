<?php
namespace App\Transformers;

use Auth;
use Illuminate\Http\Request;

class ItemTransformer
{

    /**
     * transform HTTP request
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
    */

    public static function item(Request $request)
    {   
        return $request->merge(['user_id' => Auth::id()])->all();
    }

    /**
     * Get Location Data from HTTP request
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
    */

    public static function location(Request $request)
    {
        return $request->location;
    }

}
