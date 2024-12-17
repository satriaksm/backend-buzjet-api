@extends('layouts.app')
@section('title', 'Edit Booking')

@section('content')
    <main class="w-full">
        <x-breadcrumb homeLink="bookings" homeTitle="Bookings" currentLink="#" currentTitle="Edit" />
        <!-- Fix: Remove buttonText and use plain title -->
        <x-page-header title="Edit Booking" :buttonAvailable="false" />

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User Name</label>
                        <input type="text" value="{{ $booking->user->name }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            disabled>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Package Name</label>
                        <input type="text" value="{{ $booking->package->name }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            disabled>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Price</label>
                        <input type="text" value="Rp {{ number_format($booking->total_price, 0, ',', '.') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            disabled>
                    </div>

                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select id="status" name="status"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('bookings.index') }}"
                        class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                        class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-yellow-900">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
