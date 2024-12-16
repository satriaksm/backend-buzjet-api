<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['destinations', 'hotels', 'transportations', 'user'])->get();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $packages,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'night' => 'required|integer',
            'capacity' => 'required|integer',
            'created_by' => 'required|exists:users,id',
            'destination_ids' => 'required|array',
            'destination_ids.*' => 'exists:destinations,id',
            'hotel_ids' => 'required|array',
            'hotel_ids.*' => 'exists:hotels,id',
            'transportation_ids' => 'required|array',
            'transportation_ids.*' => 'exists:transportations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors(),
            ], 422);
        }

        $package = Package::create($request->except(['destination_ids', 'hotel_ids', 'transportation_ids']));

        // Sync relationships
        $package->destinations()->sync($request->destination_ids);
        $package->hotels()->sync($request->hotel_ids);
        $package->transportations()->sync($request->transportation_ids);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $package->load(['destinations', 'hotels', 'transportations', 'user']),
        ], 201);
    }

    public function show(string $id)
    {
        $package = Package::with(['destinations', 'hotels', 'user'])->find($id);

        if (!$package) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $package,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer',
            'night' => 'nullable|integer',
            'capacity' => 'nullable|integer',
            'created_by' => 'nullable|exists:users,id',
            'destination_ids' => 'nullable|array',
            'destination_ids.*' => 'exists:destinations,id',
            'hotel_ids' => 'nullable|array',
            'hotel_ids.*' => 'exists:hotels,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal diubah',
                'errors' => $validator->errors(),
            ], 422);
        }

        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $package->update($request->except(['destination_ids', 'hotel_ids']));

        // Update relationships if provided
        if ($request->has('destination_ids')) {
            $package->destinations()->sync($request->destination_ids);
        }
        if ($request->has('hotel_ids')) {
            $package->hotels()->sync($request->hotel_ids);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah',
            'data' => $package->load(['destinations', 'hotels', 'user']),
        ]);
    }

    public function destroy(string $id)
    {
        $package = Package::findOrFail($id);

        // Delete related pivot table entries
        $package->destinations()->detach();
        $package->hotels()->detach();
        $package->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }

    public function getTransportationsByDestination($destinationId)
    {
        $destination = \App\Models\Destination::with('location')->findOrFail($destinationId);
        $transportations = \App\Models\Transportation::where('location_id', $destination->location_id)->get();

        return response()->json($transportations);
    }
}
