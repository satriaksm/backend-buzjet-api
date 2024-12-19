<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'package'])->latest()->paginate(10);
        return view('pages.admin.booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('pages.admin.booking.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        // Load the relationships to display user and package details
        $booking->load(['user', 'package']);
        return view('pages.admin.booking.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,confirmed,cancelled'
            ]);

            $booking->update($validated);

            return redirect()
                ->route('bookings.index')
                ->with('success', 'Booking status updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update booking status')
                ->withInput();
        }
    }

    public function store(Request $request)
    {
        try {
            $package = Package::findOrFail($request->package_id);

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'package_id' => $package->id,
                'seats' =>$package->seats,
                'total_price' => $package->price,
                'status' => 'pending'
            ]);

            return redirect()
                ->back()
                ->with('success', 'Booking berhasil! Silahkan tunggu konfirmasi dari admin.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal melakukan booking. Silahkan coba lagi.');
        }
    }

    // Store method is only used through the user's package booking flow
    // Remove create/store from admin interface since bookings are only created by users
}
