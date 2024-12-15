<?php

namespace App\Http\Controllers\Api;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    public function getDestinationImage($id)
    {
        // Ambil data destination dari database
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json(['error' => 'Destination not found'], 404);
        }

        // Nama file gambar dari kolom database (misalnya 'image')
        $imageName = $destination->img;

        // URL lengkap gambar
        $imageUrl = asset("storage/images/" . $imageName);

        return response()->json([
            'img' => $imageUrl,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::with('location')->get(); // Jika ada relasi dengan lokasi
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $destinations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location_id' => 'required|integer|exists:locations,id',
            'description' => 'required|string|max:1000',
            'img' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors(),
            ], 422);
        }

        $destination = Destination::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $destination,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $destination = Destination::with('location')->find($id); // Pastikan memuat relasi jika diperlukan

        if (!$destination) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $destination,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'location_id' => 'nullable|integer|exists:locations,id',
            'description' => 'nullable|string|max:1000',
            'img' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal diubah',
                'errors' => $validator->errors(),
            ], 422);
        }

        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update hanya field yang dikirim
        $destination->update($request->only(['name', 'location_id', 'description', 'img']));

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah',
            'data' => $destination,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
