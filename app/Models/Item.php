<?php
namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rating', 'category', 'image_url', 'name', 'reputation', 'price', 'availability', 'user_id'];

    
     /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['badge'];


    /**
     * Get the user that owns the Item.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the location associated with the Item.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('App\Models\Location');
    }

    /**
     * Get the Item Reputation Badge.
     *
     * @return string
     */
    public function getBadgeAttribute()
    {
        $value = $this->reputation;

        $reputation_badge = 'green';

        if($value <= 500) {
            $reputation_badge = 'red';
        } else if($value <= 799) {
            $reputation_badge = 'yellow';
        } 

        return $reputation_badge;
    }

    /**
     * Get the Item Reputation Badge.
     *
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }


    /**
     *
     * @param  \Illuminate\Database\Eloquent\Model  $query
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Database\Eloquent\Model
    */

    public function scopeFilter($query, $request)
    {
        return $query
        ->join('locations', 'locations.item_id', 'items.id' )
        ->when($request->name, function ($query, $name) {
            return $query->where('name', 'like', '%'.$name.'%');
        })->when($request->rating, function ($query, $rating) {
            return $query->where('rating', $rating);
        })->when($request->city, function ($query, $city) {
            return $query->where('locations.city', $city);
        })->when($request->reputation_badge, function ($query, $reputation_badge) {
            return $query->where('reputation_badge', $reputation_badge);
        })->when($request->category, function ($query, $category) {
            return $query->where('category', $category);
        })->when($request->availability, function ($query, $availability) {
            return $query->where('availability', $availability);
        });
    }

}
