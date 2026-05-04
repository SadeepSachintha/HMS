@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-white">{{ $title }}</h1>
        <div>
            <button type="button" class="btn btn-sm btn-success shadow-sm me-2" onclick="exportPdf()">
                <i class="fas fa-download fa-sm text-white-50"></i> Export PDF
            </button>
            <a href="{{ route('reports.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Reports
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Report Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </h6>
        </div>
        <div class="card-body">
            @if($title === 'Occupancy Report')
                <!-- Filters -->
                <form method="GET" action="{{ route('reports.generate') }}" class="row g-3 mb-4 align-items-end">
                    <input type="hidden" name="report_type" value="occupancy">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">From</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">To</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="room_type_id" class="form-label">Room Type</label>
                        <select class="form-control" id="room_type_id" name="room_type_id">
                            <option value="">All Types</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ (isset($roomTypeId) && $roomTypeId == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <button type="button" class="btn btn-success ms-2" onclick="exportExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </form>
            @endif

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
                                        <div class="h5 mb-0 font-weight-bold text-white">{{ $data['occupancy_rate'] }}%</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-white">{{ $data['total_rooms'] }}</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-white">{{ $data['occupied_rooms'] }}</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-white">LKR{{ number_format($data['total_revenue'], 2) }}</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-white">${{ number_format($data['average_revenue'], 2) }}</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-white">{{ $data['payment_count'] }}</div>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($title === 'Occupancy Report' && isset($data['breakdown']))
                <!-- Breakdown by Room Type -->
                <h5 class="mt-4">Breakdown by Room Type</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Room Type</th>
                                <th>Total Rooms</th>
                                <th>Occupied Rooms</th>
                                <th>Occupancy Rate (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['breakdown'] as $row)
                                <tr>
                                    <td>{{ $row['room_type'] }}</td>
                                    <td>{{ $row['total_rooms'] }}</td>
                                    <td>{{ $row['occupied_rooms'] }}</td>
                                    <td>{{ $row['occupancy_rate'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($title === 'Occupancy Report' && isset($data['room_details']))
                <!-- Detailed Room Occupancy Table -->
                <h5>Room Occupancy Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="occupancyTable">
                        <thead>
                            <tr>
                                <th>Room No</th>
                                <th>Room Type</th>
                                <th>Check-in Date</th>
                                <th>Check-out Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['room_details'] as $room)
                                <tr>
                                    <td>{{ $room['room_no'] }}</td>
                                    <td>{{ $room['room_type'] }}</td>
                                    <td>{{ $room['check_in'] }}</td>
                                    <td>{{ $room['check_out'] }}</td>
                                    <td><span class="badge bg-danger">{{ $room['status'] }}</span></td>
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

@if($title === 'Occupancy Report' && isset($data['room_details']))
<script>
    $(document).ready(function() {
        $('#occupancyTable').DataTable({
            order: [[0, 'asc']]
        });
    });
    function exportExcel() {
        // Redirect to the Excel export route with current filters
        const params = new URLSearchParams({
            start_date: document.getElementById('start_date').value,
            end_date: document.getElementById('end_date').value,
            room_type_id: document.getElementById('room_type_id').value
        });
        window.location.href = '{{ route('reports.occupancy.export-excel') }}?' + params.toString();
    }
</script>
@endif

<script>
    function exportPdf() {
        // Create a form with the current filter values
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("reports.export-pdf") }}';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add report type
        const reportType = document.createElement('input');
        reportType.type = 'hidden';
        reportType.name = 'report_type';
        reportType.value = 'occupancy';
        form.appendChild(reportType);

        // Add date range
        const dateRange = document.createElement('input');
        dateRange.type = 'hidden';
        dateRange.name = 'date_range';
        dateRange.value = 'custom';
        form.appendChild(dateRange);

        // Add start_date and end_date from the filter form
        const startDate = document.createElement('input');
        startDate.type = 'hidden';
        startDate.name = 'start_date';
        startDate.value = document.getElementById('start_date').value;
        form.appendChild(startDate);

        const endDate = document.createElement('input');
        endDate.type = 'hidden';
        endDate.name = 'end_date';
        endDate.value = document.getElementById('end_date').value;
        form.appendChild(endDate);

        // Add room_type_id from the filter form
        const roomTypeId = document.createElement('input');
        roomTypeId.type = 'hidden';
        roomTypeId.name = 'room_type_id';
        roomTypeId.value = document.getElementById('room_type_id').value;
        form.appendChild(roomTypeId);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>
@endsection
