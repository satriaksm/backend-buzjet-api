<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    UserController,
    BookingController,
    DestinationController,
    HotelController,
    LocationController,
    PackageController,
    TransportationController
};
use Illuminate\Support\Facades\Auth;

// Home route with role-based redirect
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('dashboard.index')
            : redirect()->route('user.index');
    }
    return redirect()->route('user.index');
})->name('home');

// Guest accessible routes
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/packages', [UserController::class, 'packages'])->name('packages');
    Route::get('/destinations', [UserController::class, 'destinations'])->name('destinations');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Booking routes for users
    Route::controller(BookingController::class)->group(function () {
        Route::post('/book-package', 'bookPackage')->name('book.package');
        Route::post('/bookings', 'store')->name('user.bookings.store');
    });
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard.index');

    // Resource routes for admin
    Route::resources([
        'destinations' => DestinationController::class,
        'hotels' => HotelController::class,
        'transportations' => TransportationController::class,
        'locations' => LocationController::class,
        'packages' => PackageController::class,
    ]);

    // Booking management routes (limited actions)
    Route::resource('bookings', BookingController::class)->only([
        'index',
        'show',
        'edit',
        'update'
    ]);
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
