<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Destination;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

    public function packages()
    {
        $packages = Package::with(['destinations', 'hotels'])
            ->latest()
            ->get();
        return view('pages.user.packages', compact('packages'));
    }

    public function destinations()
    {
        $destinations = Destination::latest()->get();
        return view('pages.user.destinations', compact('destinations'));
    }
}
