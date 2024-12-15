<?php

use App\Models\Destination;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\TransportationController;

Route::middleware(['api', 'throttle:api'])->group(function () {
    // Route::get('/hotels-by-destination/{destinationId}', [PackageController::class, 'getHotelsByDestination']);
    Route::get('/hotels-by-destination/{destinationId}', function ($destinationId) {
        $destination = Destination::with('location')->findOrFail($destinationId);

        // Dapatkan hotels berdasarkan lokasi destinasi
        $hotels = \App\Models\Hotel::where('location_id', $destination->location_id)->get();

        return response()->json($hotels);
    });
    Route::get('/transportations-by-destination/{destinationId}', [PackageController::class, 'getTransportationsByDestination']);


    Route::resource('/locations', LocationController::class);
    Route::resource('/destinations', DestinationController::class);
    Route::get('/destinations/{id}/image', [DestinationController::class, 'getDestinationImage']);
    Route::resource('/transportations', TransportationController::class);
    Route::resource('/hotels', HotelController::class);
    Route::resource('/packages', PackageController::class);

});
