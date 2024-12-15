@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<main class="w-full">
    <x-breadcrumb homeLink="dashboard" homeTitle="Dashboard" currentLink="#" currentTitle="Overview" />
    <x-page-header title="dashboard" buttonText="" :buttonAvailable="false" />

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <!-- Total Packages -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-yellow-500 bg-yellow-100 rounded-lg dark:bg-yellow-800 dark:text-yellow-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="flex-1 ms-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalPackages ?? 0 }}</h3>
                    <p class="mb-0 text-sm font-medium text-gray-500 dark:text-gray-400">Total Packages</p>
                </div>
            </div>
        </div>

        <!-- Total Destinations -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="flex-1 ms-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalDestinations ?? 0 }}</h3>
                    <p class="mb-0 text-sm font-medium text-gray-500 dark:text-gray-400">Total Destinations</p>
                </div>
            </div>
        </div>

        <!-- Total Hotels -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="flex-1 ms-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalHotels ?? 0 }}</h3>
                    <p class="mb-0 text-sm font-medium text-gray-500 dark:text-gray-400">Total Hotels</p>
                </div>
            </div>
        </div>

        <!-- Total Transportations -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-purple-500 bg-purple-100 rounded-lg dark:bg-purple-800 dark:text-purple-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div class="flex-1 ms-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalTransportations ?? 0 }}</h3>
                    <p class="mb-0 text-sm font-medium text-gray-500 dark:text-gray-400">Total Transportations</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Packages and Popular Destinations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
        <!-- Recent Packages -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Packages</h3>
                <a href="{{ route('packages.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-500">View all</a>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentPackages ?? [] as $package)
                    <li class="py-3">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $package->name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $package->duration }} Days
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="py-3 text-center text-gray-500 dark:text-gray-400">
                        No packages available
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Popular Destinations -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Popular Destinations</h3>
                <a href="{{ route('destinations.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-500">View all</a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @forelse($popularDestinations ?? [] as $destination)
                <div class="relative rounded-lg overflow-hidden">
                    <img src="{{ asset('/storage/destinations/' . $destination->img) }}"
                         class="w-full h-32 object-cover"
                         alt="{{ $destination->name }}">
                    <div class="absolute bottom-0 left-0 right-0 px-4 py-2 bg-gradient-to-t from-gray-900">
                        <h4 class="text-white text-sm font-semibold">{{ $destination->name }}</h4>
                        <p class="text-gray-300 text-xs">{{ $destination->location->city ?? 'Unknown' }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center text-gray-500 dark:text-gray-400">
                    No destinations available
                </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection
