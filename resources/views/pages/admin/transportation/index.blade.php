@extends('layouts.app')
@section('title', 'BusJet - Transportation')

@section('content')
    <main class="w-full">
        <x-breadcrumb homeLink="transportations" homeTitle="Transportation" currentLink="#" currentTitle="List" />
        <x-page-header title="transportations" buttonText="Add Transportation" :buttonAvailable="true" />

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <!-- Search bar section -->
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-6">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Search transportation...">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table section -->
            <div class="overflow-x-auto rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Name</th>
                            <th scope="col" class="px-4 py-3">Location</th>
                            <th scope="col" class="px-4 py-3">Type</th>
                            <th scope="col" class="px-4 py-3">Provider</th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transportations as $transportation)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 font-medium">{{ $transportation->name }}</td>
                                <td class="px-4 py-3">{{ $transportation->location->city ?? 'Unknown' }}, {{ $transportation->location->province ?? 'Unknown' }}</td>
                                <td class="px-4 py-3">{{ $transportation->type }}</td>
                                <td class="px-4 py-3">{{ $transportation->provider }}</td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button id="dropdown-button-{{ $transportation->id }}"
                                        data-dropdown-toggle="dropdown-{{ $transportation->id }}"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $transportation->id }}"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="dropdown-button-{{ $transportation->id }}">
                                            <li>
                                                <a href="{{ route('transportations.edit', $transportation->id) }}"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <form action="{{ route('transportations.destroy', $transportation->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="block w-full text-left py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                    No transportation available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transportations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-4">
                    {{ $transportations->links() }}
                </div>
            @endif
        </div>
    </main>

    <script>
        document.querySelectorAll('[id^="dropdown-button-"]').forEach(button => {
            button.addEventListener('click', () => {
                const menu = button.nextElementSibling;
                menu.classList.toggle('hidden');
            });
        });
    </script>
@endsection


