@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('reports.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Reports
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Report Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </h6>
        </div>
        <div class="card-body">
            @if(isset($data['occupancy_rate']))
                <!-- Occupancy Report -->
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Occupancy Rate</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['occupancy_rate'] }}%</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-bed fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Rooms</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['total_rooms'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Occupied Rooms</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['occupied_rooms'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-key fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($data['total_revenue']))
                <!-- Revenue Report -->
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Revenue</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($data['total_revenue'], 2) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Average Revenue</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($data['average_revenue'], 2) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Payments</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['payment_count'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($data['reservations']))
                <!-- Reservations Report -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="reservationsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Room</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['reservations'] as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ $reservation->customer->name }}</td>
                                    <td>{{ $reservation->room->number }}</td>
                                    <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                                    <td>{{ $reservation->check_out_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $reservation->status === 'confirmed' ? 'success' : ($reservation->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if(isset($data['reservations']))
<script>
    $(document).ready(function() {
        $('#reservationsTable').DataTable({
            order: [[0, 'desc']]
        });
    });
</script>
@endif
@endsection
