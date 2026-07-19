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
        <div class="mt-4 d-flex align-items-center gap-2">
            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Reservation
                </a>
            @endif
            @if(!$reservation->invoice)
                @if(!auth()->user()->isGuest())
                <a href="{{ route('invoices.create', ['customer_id' => $reservation->customer_id, 'reservation_id' => $reservation->id]) }}" class="btn btn-success">
                    <i class="fas fa-file-invoice-dollar me-1"></i> Generate Invoice
                </a>
                @endif
            @else
                <a href="{{ route('invoices.show', $reservation->invoice) }}" class="btn btn-info text-white">
                    <i class="fas fa-eye me-1"></i> View Generated Invoice
                </a>
            @endif
        </div>
    </div>
@endsection
