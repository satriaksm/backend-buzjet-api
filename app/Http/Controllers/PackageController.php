<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\Transportation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('user')->get(); // Relasi user di-load
        return view('pages.admin.package.index', compact('packages'));
    }

    public function create()
    {
        $admins = User::where('role', 'admin')->get();
        $destinations = Destination::all();
        $hotels = Hotel::all();
        return view('pages.admin.package.create', compact('admins', 'destinations', 'hotels'));
    }

    public function store(Request $request)
    {
        // Validasi input paket
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'night' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'destinations' => 'required|array|min:1',
            'destinations.*.destination_id' => 'required|exists:destinations,id',
            'destinations.*.hotel_id' => 'required|exists:hotels,id',
        ], [
            'destinations.required' => 'Minimal satu destinasi harus dipilih.',
            'destinations.*.destination_id.required' => 'Destinasi harus dipilih.',
            'destinations.*.hotel_id.required' => 'Hotel harus dipilih untuk setiap destinasi.',
        ]);

        // Buat paket baru
        $package = Package::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'price' => $validatedData['price'],
            'duration' => $validatedData['duration'],
            'night' => $validatedData['night'],
            'capacity' => $validatedData['capacity'],
            'created_by' => Auth::id(),
        ]);

        // Simpan destinasi dan hotel ke tabel pivot
        $destinationSync = [];
        $hotelSync = [];

        foreach ($validatedData['destinations'] as $destination) {
            $destinationSync[] = $destination['destination_id'];
            $hotelSync[] = $destination['hotel_id'];
        }

        // Gunakan sync untuk many-to-many relationship
        $package->destinations()->sync($destinationSync);
        $package->hotels()->sync($hotelSync);

        return redirect()->route('packages.index')
            ->with('success', 'Paket berhasil dibuat');
    }

    public function edit(Package $package)
    {
        $admins = User::where('role', 'admin')->get();
        $destinations = Destination::all();
        return view('pages.admin.package.edit', compact('package', 'admins', 'destinations'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'capacity' => 'required|numeric',
            'created_by' => 'required|exists:users,id',
        ]);

        $package->update($request->all());
        return redirect()->route('packages.index');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('packages.index');
    }

    public function getHotelsByDestination($destinationId)
    {
        try {
            // Log detailed information
            Log::info('Fetching hotels for destination', [
                'destination_id' => $destinationId,
                'request_method' => request()->method(),
                'full_url' => request()->fullUrl()
            ]);

            // Find the destination
            $destination = Destination::findOrFail($destinationId);

            // Log destination details
            Log::info('Destination details', [
                'destination_id' => $destination->id,
                'destination_name' => $destination->name,
                'location_id' => $destination->location_id
            ]);

            // Fetch hotels
            $hotels = Hotel::where('location_id', $destination->location_id)
                ->select('id', 'name', 'price_per_night', 'location_id')
                ->get();

            // Log hotels details
            Log::info('Hotels found', [
                'count' => $hotels->count(),
                'hotels' => $hotels->toArray()
            ]);

            // Return JSON response with more details
            return response()->json([
                'destination' => [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'location_id' => $destination->location_id
                ],
                'hotels' => $hotels
            ]);
        } catch (\Exception $e) {
            // Log the full error
            Log::error('Hotel Fetch Error', [
                'destination_id' => $destinationId,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ]);

            // Return detailed error response
            return response()->json([
                'error' => 'Unable to fetch hotels',
                'message' => $e->getMessage(),
                'destination_id' => $destinationId
            ], 500);
        }
    }

    public function getTransportationsByDestination($destinationId)
    {
        $destination = Destination::findOrFail($destinationId);
        $transportations = Transportation::where('location_id', $destination->location_id)->get();
        return response()->json($transportations);
    }
}
