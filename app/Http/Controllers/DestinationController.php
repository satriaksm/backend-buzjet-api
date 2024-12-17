<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->paginate(10);
        return view('pages.admin.destination.index', compact('destinations'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('pages.admin.destination.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'img' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/destination_images', $filename);
            $imagePath = Storage::url($path);
        }

        $destination = Destination::create([
            'name' => $request->name,
            'description' => $request->description,
            'location_id' => $request->location_id,
            'image' => $imagePath ?? null,
        ]);

        return response()->json([
            'message' => 'Destination created successfully',
            'destination' => $destination
        ], 201);
    }

    public function edit(Destination $destination)
    {
        $locations = Location::all();
        return view('pages.admin.destination.edit', compact('destination', 'locations'));
    }

    public function update(Request $request, Destination $destination)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'description' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validasi untuk gambar
        ]);

        $data = $request->all();

        // Handle upload gambar
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('destinations', $filename, 'public'); // Simpan ke folder `public/storage/destinations`

            // Hapus gambar lama jika ada
            if ($destination->img && file_exists(public_path('storage/destinations/' . $destination->img))) {
                unlink(public_path('storage/destinations/' . $destination->img));
            }

            $data['img'] = $filename; // Simpan nama file saja
        }

        $destination->update($data);

        return redirect()->route('destinations.index')->with('success', 'Destination updated successfully!');
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('destinations.index');
    }
}
