@extends('layouts.app')

@section('title', 'Dashboard - Hotel Management System')

@push('styles')
    <style>
        .dashboard-container {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid dashboard-container">
    <!-- Hero Section with Header and Stats -->
    <div class="dashboard-hero">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 position-relative" style="z-index: 1;">
            <div>
                <h1 class="h3 mb-1 text-white">Welcome Back, {{ Auth::user()->name }}!</h1>
                <p class="text-muted mb-0">Here's what's happening at your hotel today.</p>
            </div>
            <div class="d-none d-sm-inline-block">
                <button class="btn btn-primary shadow-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt fa-sm text-white-50 me-2"></i> Refresh Data
                </button>
            </div>
        </div>

        <div class="row g-4 position-relative" style="z-index: 1;">
            <!-- Occupancy Rate Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <div class="stat-icon-wrapper bg-soft-gold">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="dashboard-stat-label">Occupancy Rate</div>
                        <div class="dashboard-stat-value" id="occupancy-rate">{{ $stats['occupancy_rate'] }}%</div>
                        <div class="trend-indicator {{ $stats['occupancy_change'] >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-caret-{{ $stats['occupancy_change'] >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ abs($stats['occupancy_change']) }}% from last week
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <div class="stat-icon-wrapper bg-soft-green">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="dashboard-stat-label">Monthly Revenue</div>
                        <div class="dashboard-stat-value" id="revenue">LKR{{ number_format($stats['revenue'], 2) }}</div>
                        <div class="trend-indicator {{ $stats['revenue_change'] >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-caret-{{ $stats['revenue_change'] >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ abs($stats['revenue_change']) }}% from last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Rooms Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <div class="stat-icon-wrapper bg-soft-blue">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <div class="dashboard-stat-label">Total Rooms</div>
                        <div class="dashboard-stat-value" id="total-rooms">{{ $stats['total_rooms'] }}</div>
                        <div class="dashboard-stat-label mt-2" style="font-size: 0.75rem;">Across all categories</div>
                    </div>
                </div>
            </div>

            <!-- Available Rooms Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <div class="stat-icon-wrapper bg-soft-purple">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="dashboard-stat-label">Available Rooms</div>
                        <div class="dashboard-stat-value" id="available-rooms">{{ $stats['room_status']['available'] }}</div>
                        <div class="dashboard-stat-label mt-2" style="font-size: 0.75rem;">Ready for check-in</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="chart-container">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="section-title mb-0">Revenue Analytics</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Last 6 Months
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="chart-container h-100">
                <h5 class="section-title">Room Inventory</h5>
                <div class="chart-wrapper" style="height: 200px;">
                    <canvas id="inventoryChart"></canvas>
                </div>
                <div class="mt-4">
                    <div class="room-status-item">
                        <span><span class="room-status-dot dot-available"></span>Available</span>
                        <span class="fw-bold">{{ $stats['room_status']['available'] }}</span>
                    </div>
                    <div class="room-status-item">
                        <span><span class="room-status-dot dot-occupied"></span>Occupied</span>
                        <span class="fw-bold">{{ $stats['room_status']['occupied'] }}</span>
                    </div>
                    <div class="room-status-item">
                        <span><span class="room-status-dot dot-maintenance"></span>Maintenance</span>
                        <span class="fw-bold">{{ $stats['room_status']['maintenance'] }}</span>
                    </div>
                    <div class="room-status-item">
                        <span><span class="room-status-dot dot-dirty"></span>Dirty</span>
                        <span class="fw-bold">{{ $stats['room_status']['dirty'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lower Section: Recent Activity and Quick Actions -->
    <div class="row">
        <!-- Recent Reservations -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card h-100 border-0 shadow-sm" style="background: #070D20;">
                <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-4 px-4">
                    <h5 class="section-title mb-0">Recent Reservations</h5>
                    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-link text-secondary p-0">View All</a>
                </div>
                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table class="table table-hover recent-reservations-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">RES. ID</th>
                                    <th>Room</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_reservations'] as $reservation)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-initials me-3" style="background: rgba(212, 175, 55, 0.1); color: #D4AF37;">
                                                <i class="fas fa-hashtag"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-white">#RES-{{ sprintf('%05d', $reservation->id) }}</div>
                                                <div class="small text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">{{ $reservation->customer->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $reservation->room->number }}</div>
                                        <div class="small text-muted">{{ $reservation->room->roomType->name }}</div>
                                    </td>
                                    <td>
                                        <div class="small">{{ $reservation->check_in_date->format('M d') }} - {{ $reservation->check_out_date->format('M d') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $reservation->status === 'confirmed' ? 'success' : ($reservation->status === 'pending' ? 'warning' : 'danger') }} bg-opacity-10 text-{{ $reservation->status === 'confirmed' ? 'success' : ($reservation->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Upcoming -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="row g-3">
                <div class="col-12">
                    <h5 class="section-title mb-3">Quick Actions</h5>
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('reservations.create') }}" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-plus-circle text-success"></i>
                                <span>New Booking</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('customers.create') }}" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-user-plus text-info"></i>
                                <span>Add Guest</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('rooms.index') }}" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-door-open text-warning"></i>
                                <span>Room Status</span>
                            </a>
                        </div>
                        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                        <div class="col-6">
                            <a href="{{ route('reports.index') }}" class="quick-action-btn text-decoration-none">
                                <i class="fas fa-file-alt text-primary"></i>
                                <span>Reports</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-12 mt-4">
                    <h5 class="section-title mb-3">Today's Arrivals</h5>
                    <div class="card border-0 shadow-sm" style="background: #070D20;">
                        <div class="card-body">
                            @forelse($stats['upcoming_arrivals'] as $arrival)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-secondary border-opacity-10">
                                    <div class="avatar-initials me-3" style="width: 30px; height: 30px; font-size: 0.7rem;">
                                        {{ substr($arrival->customer->name, 0, 2) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small text-white">{{ $arrival->customer->name }}</div>
                                        <div class="small text-muted">Room {{ $arrival->room->number }}</div>
                                    </div>
                                    <a href="{{ route('reservations.show', $arrival->id) }}" class="btn btn-sm btn-primary py-0 px-2" style="font-size: 0.7rem;">Check-in</a>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-day text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted small mb-0">No arrivals scheduled for today.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/vendor/pusher.min.js') }}"></script>
    <script src="{{ asset('js/vendor/chart.min.js') }}"></script>
    <script>
        // Pass PHP data to JS
        const dashboardData = {
            revenueChart: @json($stats['revenue_chart']),
            occupancyChart: @json($stats['occupancy_chart']),
            roomStatus: @json($stats['room_status'])
        };
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
