@extends('layouts.app')
@section('title', 'Create Package')

@section('content')
<main class="w-full" x-data="{
    destinations: [
        {
            destination_id: '',
            hotel_id: '',
            hotels: [],
            transportation_id: '',
            transportations: []
        }
    ],

    async getHotelsAndTransportations(destinationId, index) {
        if (!destinationId) {
            this.destinations[index].hotels = [];
            this.destinations[index].transportations = [];
            this.destinations[index].hotel_id = '';
            this.destinations[index].transportation_id = '';
            return;
        }
        try {
            // Fetch hotels for the selected destination's location
            const hotelsResponse = await fetch(`/api/hotels-by-destination/${destinationId}`);
            const hotels = await hotelsResponse.json();
            this.destinations[index].hotels = hotels;

            // Fetch transportations for the selected destination's location
            const transportationsResponse = await fetch(`/api/transportations-by-destination/${destinationId}`);
            const transportations = await transportationsResponse.json();
            this.destinations[index].transportations = transportations;
            
            console.log('Transportations:', transportations); // Add this for debugging
        } catch (error) {
            console.error('Error fetching hotels and transportations:', error);
        }
    },

    addDestination() {
        this.destinations.push({
            destination_id: '',
            hotel_id: '',
            hotels: [],
            transportation_id: '',
            transportations: []
        });
    },

    removeDestination(index) {
        this.destinations.splice(index, 1);
    }
}">
    <x-breadcrumb homeLink="packages" homeTitle="Packages" currentLink="#" currentTitle="Create" />
    <x-page-header title="packages" buttonText="New Package" :buttonAvailable=false />

    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Package Name</label>
                    <input type="text" id="name" name="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('name') }}" required />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                    <input type="number" id="price" name="price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('price') }}" required />
                    @error('price')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                <div>
                    <label for="duration" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duration (Days)</label>
                    <input type="number" id="duration" name="duration"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('duration') }}" required />
                    @error('duration')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="night" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nights</label>
                    <input type="number" id="night" name="night"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('night') }}" required />
                    @error('night')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Capacity</label>
                    <input type="number" id="capacity" name="capacity"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('capacity') }}" required />
                    @error('capacity')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Destinations Section -->
            <div class="mb-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Destinations</h3>
                    <button type="button"
                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"
                        @click="addDestination">
                        + Add Destination
                    </button>
                </div>

                <template x-for="(dest, index) in destinations" :key="index">
                    <div class="p-4 mb-4 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Destination <span x-text="index + 1"></span>
                                </label>
                                <select :name="'destinations['+index+'][destination_id]'"
                                    x-model="dest.destination_id"
                                    @change="getHotelsAndTransportations($event.target.value, index)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select Destination</option>
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Hotel for Destination <span x-text="index + 1"></span>
                                </label>
                                <select :name="'destinations['+index+'][hotel_id]'"
                                    x-model="dest.hotel_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">
                                        <span x-text="dest.destination_id ? 'Select Hotel' : 'Select Destination first'"></span>
                                    </option>
                                    <template x-for="hotel in dest.hotels" :key="hotel.id">
                                        <option :value="hotel.id" x-text="hotel.name + ' (' + hotel.price_per_night + '/night)'"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Transportation for Destination <span x-text="index + 1"></span>
                                </label>
                                <select :name="'destinations['+index+'][transportation_id]'"
                                    x-model="dest.transportation_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">
                                        <span x-text="dest.destination_id ? 'Select Transportation' : 'Select Destination first'"></span>
                                    </option>
                                    <template x-for="transport in dest.transportations" :key="transport.id">
                                        <option :value="transport.id" x-text="transport.type + ' - ' + transport.name + ' (' + transport.provider + ')'"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <template x-if="destinations.length > 1">
                            <button type="button"
                                class="mt-4 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"
                                @click="removeDestination(index)">
                                Remove Destination
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            <button type="submit"
                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:focus:ring-yellow-900">
                Create Package
            </button>
        </form>
    </div>
</main>
@endsection