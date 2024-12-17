<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;

// Root redirect to dashboard (update this to check role first)
Route::get('/', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('home'); // You should create a home route for regular users
})->middleware(['auth', 'verified']);

// Dashboard route with controller (add role:admin middleware)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard.index');

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/book-package', [BookingController::class, 'bookPackage'])->middleware('auth');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('destinations', DestinationController::class);
    Route::resource('hotels', HotelController::class);
    Route::resource('transportations', TransportationController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('packages', PackageController::class);
    Route::get('/bookings', [BookingController::class, 'showBookings']);
});

// Image handling route
Route::get('/images/{folder}/{filename}', function ($folder, $filename) {
    $path = resource_path('images/' . $folder . '/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path);
});


require __DIR__ . '/auth.php';
