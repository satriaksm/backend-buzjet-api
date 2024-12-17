<?php

use App\Models\Destination;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\TransportationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

// Public routes (no auth required)
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    // Other protected resources
    Route::resource('/locations', LocationController::class);
    Route::resource('/destinations', DestinationController::class);
    Route::get('/destinations/{id}/image', [DestinationController::class, 'getImage']);
    Route::resource('/transportations', TransportationController::class);
    Route::resource('/hotels', HotelController::class);
    Route::resource('/packages', PackageController::class);
    Route::apiResource('users', UserController::class);
});

// Public routes for fetching data
Route::get('/hotels-by-destination/{destinationId}', [PackageController::class, 'getHotelsByDestination']);
Route::get('/transportations-by-destination/{destinationId}', [PackageController::class, 'getTransportationsByDestination']);
