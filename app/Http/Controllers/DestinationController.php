<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use OpenApi\Attributes as OA;

class DestinationController extends Controller
{
    #[OA\Get(path: "/api/destinations",summary: "Get all destinations",tags: ["Destinations"])]
    #[OA\Response(response: 200, description: "List of destinations")]
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $itinerary = Itinerary::with('destinations')->findOrFail($itinerary_id);
        // return response()->json($itinerary->destinations);
        return response()->json(Destination::all());
    }

    #[OA\Post(path: "/api/destinations",summary: "Create a destination",tags: ["Destinations"],security: [["sanctumAuth" => []]])]
    #[OA\Parameter(name: "name", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "longment", in: "query", required: true, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "activite", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "place", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "food", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "itinerary_id", in: "query", required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Response(response: 201, description: "Destination created successfully")]
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255','longment' => 'required|string|max:255','itinerary_id' => 'required|exists:itineraries,id']);
        $destination = Destination::create($request->all());
        return response()->json($destination, 201);
    }

    #[OA\Get(path: "/api/destinations/{id}",summary: "Get destination by ID",tags: ["Destinations"])]
    #[OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Response(response: 200, description: "Destination found")]
    #[OA\Response(response: 404, description: "Destination not found")]
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $destination = Destination::findOrFail($id);
        return response()->json($destination);
    }

    #[OA\Put(path: "/api/destinations/{id}",summary: "Update destination",tags: ["Destinations"],security: [["sanctumAuth" => []]])]
    #[OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Parameter(name: "name", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "longment", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "activite", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "place", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Parameter(name: "food", in: "query", required: false, schema: new OA\Schema(type: "string"))]
    #[OA\Response(response: 200, description: "Destination updated")]
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $destination->update($request->all());
        return response()->json($destination);
    }

    #[OA\Delete(path: "/api/destinations/{id}",summary: "Delete destination",tags: ["Destinations"],security: [["sanctumAuth" => []]])]
    #[OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Response(response: 200, description: "Destination deleted")]
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
