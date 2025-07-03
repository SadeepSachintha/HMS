@extends('layouts.app')

@section('title', 'Dashboard - Hotel Management System')

@section('styles')
<style>
    .card-dashboard {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    .card-dashboard:hover {
        transform: translateY(-5px);
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
        font-weight: bold;
    }
    .stats-icon {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    .occupancy-chart-container, .revenue-chart-container {
        height: 300px;
    }
    .stat-value {
        transition: all 0.3s ease;
    }
    .stat-value.updating {
        transform: scale(1.1);
        color: #4e73df;
    }
</style>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Stats Overview Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Occupancy Rate</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stat-value" id="occupancy-rate">{{ $stats['occupancy_rate'] }}%</div>
                        <div class="text-xs text-muted" id="occupancy-change">{{ $stats['occupancy_change'] }}% increase from last week</div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon bg-primary text-white">
                            <i class="fas fa-bed"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Revenue (Daily)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stat-value" id="revenue">${{ number_format($stats['revenue'], 2) }}</div>
                        <div class="text-xs text-muted" id="revenue-change">{{ $stats['revenue_change'] }}% increase from yesterday</div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon bg-success text-white">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Rooms</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stat-value" id="total-rooms">{{ $stats['total_rooms'] }}</div>
                        <div class="text-xs text-muted">All available rooms</div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon bg-info text-white">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 card-dashboard">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Occupied Rooms</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 stat-value" id="occupied-rooms">{{ $stats['occupied_rooms'] }}</div>
                        <div class="text-xs text-muted">Currently occupied</div>
                    </div>
                    <div class="col-auto">
                        <div class="stats-icon bg-warning text-white">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4 card-dashboard">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
                <h6 class="m-0 font-weight-bold">Occupancy & Revenue Trends</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-white"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Chart Options:</div>
                        <a class="dropdown-item" href="#">Last 7 Days</a>
                        <a class="dropdown-item" href="#">Last 30 Days</a>
                        <a class="dropdown-item" href="#">This Year</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Download Report</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="occupancy-chart-container">
                    <canvas id="occupancyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4 card-dashboard">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-info text-white">
                <h6 class="m-0 font-weight-bold">Room Type Distribution</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-white"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Chart Options:</div>
                        <a class="dropdown-item" href="#">By Occupancy</a>
                        <a class="dropdown-item" href="#">By Revenue</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Download Report</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="revenue-chart-container">
                    <canvas id="roomTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
