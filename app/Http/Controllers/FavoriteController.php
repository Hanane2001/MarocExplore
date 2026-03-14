<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Itinerary;
use OpenApi\Attributes as OA;

class FavoriteController extends Controller
{
    #[OA\Get(path: "/api/favorites",summary: "Get user favorites",tags: ["Favorites"],security: [["sanctumAuth" => []]])]
    #[OA\Response(response: 200, description: "List of favorites")]
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Favorite::with('itinerary')->where('user_id', auth()->id())->get();
        return response()->json($favorites);
    }

    #[OA\Post(path: "/api/itineraries/{id}/favorite",summary: "Add itinerary to favorites",tags: ["Favorites"],security: [["sanctumAuth" => []]])]
    #[OA\Parameter(name: "id",in: "path",required: true,description: "Itinerary ID",schema: new OA\Schema(type: "integer"))]
    #[OA\Response(response: 201, description: "Itinerary added to favorites")]
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

    #[OA\Delete(path: "/api/favorites/{id}/favorite",summary: "Remove itinerary from favorites",tags: ["Favorites"],security: [["sanctumAuth" => []]])]
    #[OA\Parameter(name: "id",in: "path",required: true,description: "Itinerary ID",schema: new OA\Schema(type: "integer"))]
    #[OA\Response(response: 200, description: "Removed from favorites")]
    #[OA\Response(response: 404, description: "Favorite not found")]
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
