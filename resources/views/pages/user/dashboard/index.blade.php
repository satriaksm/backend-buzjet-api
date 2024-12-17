<x-user-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h2>
                    <p>This is your user dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
