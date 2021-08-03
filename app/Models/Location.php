<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['city', 'state', 'country', 'zip_code', 'address', 'item_id'];

    /**
     * Get the location that owns the item.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

     */
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

}

