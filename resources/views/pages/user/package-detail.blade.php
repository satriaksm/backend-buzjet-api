// ...existing code...

<form action="{{ route('user.bookings.store') }}" method="POST" class="mt-4">
    @csrf
    <input type="hidden" name="package_id" value="{{ $package->id }}">
    <button type="submit"
        class="w-full text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-yellow-900">
        Book Now
    </button>
</form>

// ...existing code...
