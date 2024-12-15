<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Location;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('pages.destination.index', compact('destinations'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('pages.destination.create', compact('locations'));
    }

    public function store(Request $request)
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
            $data['img'] = $filename; // Simpan nama file saja
        }

        Destination::create($data);

        return redirect()->route('destinations.index')->with('success', 'Destination created successfully!');
    }



    public function edit(Destination $destination)
    {
        $locations = Location::all();
        return view('pages.destination.edit', compact('destination', 'locations'));
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
