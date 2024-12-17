<?php

namespace App\Http\Controllers\Api;

use App\Models\Transportation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Destination;

class TransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transportations = Transportation::with('location')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $transportations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'provider' => 'required|string|max:255',
            'location_id' => 'required|integer|exists:locations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors(),
            ], 422);
        }

        $transportation = Transportation::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $transportation,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transportation = Transportation::with('location')->find($id);

        if (!$transportation) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $transportation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'provider' => 'nullable|string|max:255',
            'location_id' => 'nullable|integer|exists:locations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal diubah',
                'errors' => $validator->errors(),
            ], 422);
        }

        $transportation = Transportation::find($id);

        if (!$transportation) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $transportation->update($request->only(['type', 'name', 'price', 'provider', 'location_id']));

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah',
            'data' => $transportation,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transportation = Transportation::findOrFail($id);
        $transportation->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }

    public function getByDestination($destinationId)
    {
        $destination = Destination::with('location')->findOrFail($destinationId);
        $transportations = Transportation::where('location_id', $destination->location_id)->get();

        return response()->json($transportations);
    }
}
