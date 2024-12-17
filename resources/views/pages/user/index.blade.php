<x-user-layout>
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="p-8 text-center sm:p-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Welcome to BuzJet Travel
                    </h2>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                        Find your perfect travel package and explore amazing destinations
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('user.packages') }}" class="inline-block px-12 py-3 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded active:text-blue-500 hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring">
                            View Packages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
