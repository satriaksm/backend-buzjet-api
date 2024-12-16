<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function bookPackage(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'img' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $package = Package::find($request->package_id);

        // Handle file upload
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/booking_images', $filename);
            $imgPath = Storage::url($path);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'status' => 'pending',
            'total_price' => $package->price,
            'img' => $imgPath ?? null,
        ]);

        return response()->json([
            'message' => 'Package booked successfully',
            'booking' => $booking
        ], 201);
    }

    public function showBookings()
    {
        $bookings = Booking::with('user', 'package')->get();
        return view('pages.booking.index', compact('bookings'));
    }
}
