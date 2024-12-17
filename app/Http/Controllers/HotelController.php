<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Location;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('pages.admin.hotel.index', compact('hotels'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('pages.admin.hotel.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'required|numeric',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        Hotel::create($request->all());
        return redirect()->route('hotels.index');
    }

    public function edit(Hotel $hotel)
    {
        $locations = Location::all();
        return view('pages.admin.hotel.edit', compact('hotel', 'locations'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'required|numeric',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        $hotel->update($request->all());
        return redirect()->route('hotels.index');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index');
    }
}

