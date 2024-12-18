<x-user-layout>
    @push('scripts')
        <script>
            // Define functions before DOM loads
            window.bookingFunctions = {
                openBookingModal: function(packageData) {
                    window.currentPackage = packageData;
                    document.getElementById('bookingModal').classList.remove('hidden');
                    document.getElementById('modalTitle').textContent = packageData.name;
                    this.updateTotal();
                },
                closeBookingModal: function() {
                    document.getElementById('bookingModal').classList.add('hidden');
                    window.currentPackage = null;
                },
                updateTotal: function() {
                    const seats = document.getElementById('seatsInput').value;
                    const total = window.currentPackage.price * seats;
                    document.getElementById('totalPrice').textContent =
                        'Rp ' + total.toLocaleString('id-ID');
                },
                confirmBooking: async function() {
                    const seats = document.getElementById('seatsInput').value;

                    try {
                        const response = await fetch('/api/bookings', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': 'Bearer ' +
                                    '{{ auth()->user()->createToken('auth-token')->plainTextToken }}'
                            },
                            body: JSON.stringify({
                                package_id: window.currentPackage.id,
                                seats: parseInt(seats)
                            })
                        });

                        const data = await response.json();

                        if (data.status) {
                            alert('Booking created successfully!');
                            this.closeBookingModal();
                            location.reload();
                        } else {
                            alert('Failed to create booking: ' + data.message);
                        }
                    } catch (error) {
                        alert('Error creating booking: ' + error.message);
                    }
                }
            };

            // Explicitly set the function on window object
            window.openBookingModal = function(packageData) {
                window.bookingFunctions.openBookingModal(packageData);
            };

            // Initialize after DOM loads
            document.addEventListener('DOMContentLoaded', function() {
                // Make functions globally available
                window.closeBookingModal = window.bookingFunctions.closeBookingModal.bind(window.bookingFunctions);
                window.confirmBooking = window.bookingFunctions.confirmBooking.bind(window.bookingFunctions);

                // Add event listener for seats input
                document.getElementById('seatsInput').addEventListener('input',
                    window.bookingFunctions.updateTotal.bind(window.bookingFunctions));
            });
        </script>
    @endpush

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Discover Our Premium Travel Packages
                </h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300">
                    Choose from our carefully curated selection of exclusive travel experiences
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($packages as $package)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transform transition duration-500 hover:scale-105">
                        <!-- Package Image -->
                        <div class="relative h-48 bg-blue-600">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $package->name }}</h3>
                                <div class="flex items-center text-white/90 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 110-12 6 6 0 010 12zm0-9a1 1 0 011 1v4a1 1 0 11-2 0V8a1 1 0 011-1z" />
                                    </svg>
                                    Limited time offer
                                </div>
                            </div>
                        </div>

                        <!-- Package Details -->
                        <div class="p-6">
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-6">
                                {{ Str::limit($package->description, 100) }}</p>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-blue-50 dark:bg-gray-700 p-3 rounded-lg">
                                    <div class="flex items-center text-blue-600 dark:text-blue-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold">Duration</span>
                                    </div>
                                    <p class="mt-1 text-gray-900 dark:text-white font-bold">{{ $package->duration }}
                                        Days</p>
                                </div>

                                <div class="bg-blue-50 dark:bg-gray-700 p-3 rounded-lg">
                                    <div class="flex items-center text-blue-600 dark:text-blue-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-semibold">Capacity</span>
                                    </div>
                                    <p class="mt-1 text-gray-900 dark:text-white font-bold">{{ $package->capacity }}
                                        Persons</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Starting from</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="window.openBookingModal({{ json_encode($package) }})"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Book Now
                                    </button>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <button type="button"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium inline-flex items-center">
                                    View Package Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Booking Modal (dengan styling yang lebih baik) -->
    <div id="bookingModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full backdrop-blur-sm transition-all duration-300">
        <div
            class="relative top-20 mx-auto p-8 border w-full max-w-md shadow-2xl rounded-2xl bg-white dark:bg-gray-800 transform transition-all">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white" id="modalTitle"></h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Please confirm your booking details</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Number of Seats
                    </label>
                    <input type="number" id="seatsInput" min="1" value="1"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Total Price
                    </label>
                    <p id="totalPrice" class="text-3xl font-bold text-blue-600 dark:text-blue-400"></p>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <button onclick="window.closeBookingModal()"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                        Cancel
                    </button>
                    <button onclick="window.confirmBooking()"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-300">
                        Confirm Booking
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
