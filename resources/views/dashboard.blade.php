@extends('layouts.app')

@section('title', 'Dashboard - Hotel Management System')

@section('styles')
    <style>
        .card-dashboard {
            transition: all 0.3s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
            border-color: var(--secondary-color) !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3) !important;
        }

        .stats-icon {
            font-size: 1.5rem;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .occupancy-chart-container,
        .revenue-chart-container {
            height: 300px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            color: var(--text-color);
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-change {
            font-size: 0.85rem;
        }
    </style>
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Stats Overview Cards -->
    <div class="row mb-4">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2 card-dashboard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-label mb-1">Occupancy Rate</div>
                            <div class="stat-value" id="occupancy-rate">{{ $stats['occupancy_rate'] }}%</div>
                            <div class="stat-change text-success" id="occupancy-change">
                                <i class="fas fa-caret-up me-1"></i>{{ $stats['occupancy_change'] }}% increase
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon">
                                <i class="fas fa-bed"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2 card-dashboard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-label mb-1">Revenue (Monthly)</div>
                            <div class="stat-value" id="revenue">LKR{{ number_format($stats['revenue'], 2) }}</div>
                            <div class="stat-change text-success" id="revenue-change">
                                <i class="fas fa-caret-up me-1"></i>{{ $stats['revenue_change'] }}% increase
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2 card-dashboard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-label mb-1">Total Rooms</div>
                            <div class="stat-value" id="total-rooms">{{ $stats['total_rooms'] }}</div>
                            <div class="stat-change text-muted">All available rooms</div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning h-100 py-2 card-dashboard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-label mb-1">Occupied Rooms</div>
                            <div class="stat-value" id="occupied-rooms">{{ $stats['occupied_rooms'] }}</div>
                            <div class="stat-change text-muted">Currently occupied</div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon">
                                <i class="fas fa-door-open"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/vendor/pusher.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
