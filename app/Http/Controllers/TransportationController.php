<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\Location;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function index()
    {
        $transportations = Transportation::all();
        return view('pages.admin.transportation.index', compact('transportations'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('pages.admin.transportation.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'provider' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
        ]);

        Transportation::create($request->all());
        return redirect()->route('transportations.index');
    }

    public function edit(Transportation $transportation)
    {
        $locations = Location::all();
        return view('pages.admin.transportation.edit', compact('transportation', 'locations'));
    }

    public function update(Request $request, Transportation $transportation)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'provider' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
        ]);

        $transportation->update($request->all());
        return redirect()->route('transportations.index');
    }

    public function destroy(Transportation $transportation)
    {
        $transportation->delete();
        return redirect()->route('transportations.index');
    }
}
