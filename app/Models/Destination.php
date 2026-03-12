<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\itinerary;

class Destination extends Model
{
    protected $fillable = ['name', 'longment', 'activite', 'place', 'food', 'itinerary_id'];
    public function itinerary(){
        return $this->belongsTo(Itinerary::class);
    }
}
