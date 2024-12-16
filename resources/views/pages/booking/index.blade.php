@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bookings</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Package</th>
                <th>Status</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->package->name }}</td>
                <td>{{ $booking->status }}</td>
                <td>{{ $booking->total_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
