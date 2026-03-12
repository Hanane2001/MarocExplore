<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Itinerary;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Favorite::with('itinerary')->where('user_id', auth()->id())->get();
        return response()->json($favorites);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id)
    {
        $itinerary = Itinerary::findOrFail($id);
        $favorite = Favorite::create(['user_id' => auth()->id(),'itinerary_id' => $itinerary->id]);
        return response()->json(['message' => 'Itinerary added to favorites','favorite' => $favorite],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', auth()->id())->where('itinerary_id', $id)->first();
        if(!$favorite){
            return response()->json(['message'=>'Favorite not found'],404);
        }
        $favorite->delete();
        return response()->json(['message'=>'Removed from favorites']);
    }
}
