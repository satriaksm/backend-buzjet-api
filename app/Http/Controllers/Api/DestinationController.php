<?php

namespace App\Http\Controllers\Api;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    public function getImage($id)
    {
        $destination = Destination::findOrFail($id);

        // Debug image filename
        Log::info('Image filename: ' . $destination->img);

        // Correct path construction
        $path = public_path(basename($destination->img));

        // Debug full path
        Log::info('Full path: ' . $path);

        if (!file_exists($path)) {
            return response()->json([
                'status' => false,
                'message' => 'Image not found',
                'path' => $path,
                'image_name' => $destination->img
            ], 404);
        }

        return response()->file($path);
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
            'img' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal ditambahkan',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Handle file upload
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Store file directly to public directory
                $file->move(public_path('storage/destinations'), $filename);

                // Save only filename
                $imgPath = $filename;
            }

            $destination = Destination::create([
                'name' => $request->name,
                'location_id' => $request->location_id,
                'description' => $request->description,
                'img' => $imgPath ?? null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $destination,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error uploading file: ' . $e->getMessage(),
            ], 500);
        }
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
            'img' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal diubah',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $destination = Destination::find($id);
            if (!$destination) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }

            $data = $request->only(['name', 'location_id', 'description']);

            // Handle file upload
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Delete old image if exists
                if ($destination->img && file_exists(public_path('storage/destinations/' . $destination->img))) {
                    unlink(public_path('storage/destinations/' . $destination->img));
                }

                // Store new file directly to public directory
                $file->move(public_path('storage/destinations'), $filename);
                $data['img'] = $filename;
            }

            $destination->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah',
                'data' => $destination->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating file: ' . $e->getMessage(),
            ], 500);
        }
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
