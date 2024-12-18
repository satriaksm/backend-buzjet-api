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
use App\Http\Controllers\Api\BookingController;

// Public routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Routes for all authenticated users
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    // Routes only for viewing packages (both admin and regular users)
    Route::get('/packages', [PackageController::class, 'index']);
    Route::get('/packages/{id}', [PackageController::class, 'show']);

    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::resource('/locations', LocationController::class);
        Route::resource('/destinations', DestinationController::class);
        Route::get('/destinations/{id}/image', [DestinationController::class, 'getImage']);
        Route::resource('/transportations', TransportationController::class);
        Route::resource('/hotels', HotelController::class);
        // Package routes except index and show
        Route::resource('/packages', PackageController::class)->except(['index', 'show']);
        Route::apiResource('users', UserController::class);
        Route::patch('/bookings/{id}/status', [BookingController::class, 'updateStatus']);
    });

    Route::apiResource('bookings', BookingController::class);
});

