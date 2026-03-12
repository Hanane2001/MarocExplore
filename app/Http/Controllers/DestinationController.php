<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itinerary = Itinerary::with('destinations')->findOrFail($itinerary_id);
        return response()->json($itinerary->destinations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255','longment' => 'required|string|max:255','itinerary_id' => 'required|exists:itineraries,id']);
        $destination = Destination::create($request->all());
        return response()->json($destination, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $destination = Destination::findOrFail($id);
        return response()->json($destination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $destination->update($request->all());
        return response()->json($destination);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return response()->json(['message'=>'Destination deleted']);
    }
}
