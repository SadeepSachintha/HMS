@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Customer Details</h1>
        <div>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Customer
            </a>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Name:</th>
                            <td>{{ $customer->name ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $customer->email ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $customer->phone ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $customer->address ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>City:</th>
                            <td>{{ $customer->city ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>State:</th>
                            <td>{{ $customer->state ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>Postal Code:</th>
                            <td>{{ $customer->postal_code ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td>{{ $customer->country ?? 'No data available' }}</td>
                        </tr>
                        <tr>
                            <th>Loyalty Points:</th>
                            <td>{{ $customer->loyalty_points ?? '0' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                        </div>
                        <div class="card-body">
                            {{ $customer->notes ?? 'No notes available.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservations Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reservation History</h6>
        </div>
        <div class="card-body">
            @if($customer->reservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->room->number ?? 'N/A' }}</td>
                                    <td>{{ $reservation->check_in_date->format('Y-m-d') }}</td>
                                    <td>{{ $reservation->check_out_date->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge bg-{{
                                            $reservation->status === 'confirmed' ? 'success' :
                                            ($reservation->status === 'pending' ? 'warning' :
                                            ($reservation->status === 'checked_in' ? 'info' :
                                            ($reservation->status === 'checked_out' ? 'secondary' :
                                            ($reservation->status === 'cancelled' ? 'danger' : 'secondary'))))
                                        }}">
                                            {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No reservations found for this customer.</p>
            @endif
        </div>
    </div>
</div>
@endsection
