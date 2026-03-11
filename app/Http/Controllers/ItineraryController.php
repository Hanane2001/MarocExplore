<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Itinerary::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string','category' => 'required','duration' => 'required|integer']);
        $itinerary = Itinerary::create(['title' => $request->title,'category' => $request->category,'duration' => $request->duration,'image' => $request->image,'user_id' => auth()->id()]);
        return response()->json($itinerary,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Itinerary::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $itinerary = Itinerary::findOrFail($id);
        if($itinerary->user_id != auth()->id()){
            return response()->json(['message'=>'Unauthorized'],403);
        }
        $itinerary->update($request->all());
        return response()->json($itinerary);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itinerary = Itinerary::findOrFail($id);
        if($itinerary->user_id != auth()->id()){
            return response()->json(['message'=>'Unauthorized'],403);
        }
        $itinerary->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
