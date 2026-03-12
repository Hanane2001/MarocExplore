<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Itinerary extends Model
{
    protected $fillable = ['title','category','duration','image','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function favorites(){
        return $this->hasMany(Favorite::class);
    }
}
