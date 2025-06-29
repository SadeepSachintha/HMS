@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reservation Details</h1>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary mb-3">Back to List</a>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $reservation->id }}</p>
            <p><strong>Customer:</strong> {{ $reservation->customer->name ?? 'N/A' }}</p>
            <p><strong>Room:</strong> {{ $reservation->room->number ?? 'N/A' }}</p>
            <p><strong>Check In:</strong> {{ $reservation->check_in_date }}</p>
            <p><strong>Check Out:</strong> {{ $reservation->check_out_date }}</p>
            <p><strong>Number of Guests:</strong> {{ $reservation->number_of_guests }}</p>
            <p><strong>Status:</strong> {{ ucfirst($reservation->status) }}</p>
        </div>
    </div>
</div>
@endsection
