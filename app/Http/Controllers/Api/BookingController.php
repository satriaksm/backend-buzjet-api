<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'package'])->where('user_id', Auth::id())->get();
        return response()->json([
            'status' => true,
            'message' => 'Bookings retrieved successfully',
            'data' => $bookings
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Booking request received', [
            'headers' => $request->headers->all(),
            'data' => $request->all()
        ]);
        $validator = Validator::make($request->all(), [
            'package_id' => 'required|exists:packages,id',
            'seats' => 'required|integer|min:1|max:10' // tambahkan max seats sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $package = Package::findOrFail($request->package_id);
            $total_price = $package->price * $request->seats;

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'package_id' => $package->id,
                'seats' => $request->seats,
                'total_price' => $total_price,
                'status' => 'pending'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Booking created successfully',
                'data' => $booking->load(['user', 'package'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'package'])->find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Booking details retrieved successfully',
            'data' => $booking
        ]);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Check if user is owner of the booking
        if ($booking->user_id !== Auth::id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'seats' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $total_price = $booking->package->price * $request->seats;

            $booking->update([
                'seats' => $request->seats,
                'total_price' => $total_price
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Booking updated successfully',
                'data' => $booking->load(['user', 'package'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Admin method to update booking status
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::user()->is_admin) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $booking = Booking::findOrFail($id);
            $booking->update(['status' => $request->status]);

            return response()->json([
                'status' => true,
                'message' => 'Booking status updated successfully',
                'data' => $booking->load(['user', 'package'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update booking status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();

            return response()->json([
                'status' => true,
                'message' => 'Booking deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
