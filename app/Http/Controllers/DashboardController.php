<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Transportation;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalPackages' => Package::count(),
            'totalDestinations' => Destination::count(),
            'totalHotels' => Hotel::count(),
            'totalTransportations' => Transportation::count(),
            'recentPackages' => Package::latest()->take(5)->get(),
            'popularDestinations' => Destination::latest()->take(4)->get(),
        ];

        return view('pages.dashboard.index', $data);
    }
}
