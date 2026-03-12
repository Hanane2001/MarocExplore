<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FavoriteController;


Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::middleware('auth:sanctum')->post('/logout',[AuthController::class,'logout']);

Route::get('/itineraries', [ItineraryController::class,'index']);
Route::get('/itineraries/{id}', [ItineraryController::class,'show']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/itineraries', [ItineraryController::class,'store']);
    Route::put('/itineraries/{id}', [ItineraryController::class,'update']);
    Route::delete('/itineraries/{id}', [ItineraryController::class,'destroy']);

    Route::post('/destinations', [DestinationController::class,'store']);

    Route::get('/favorites',[FavoriteController::class,'index']);
    Route::post('/itineraries/{id}/favorite',[FavoriteController::class,'store']);
    Route::delete('/favorites/{id}/favorite',[FavoriteController::class,'destroy']);

});
?>