@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Generate Reports</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Report Configuration</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.generate') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="report_type">Report Type</label>
                            <select class="form-control @error('report_type') is-invalid @enderror" id="report_type" name="report_type" required>
                                <option value="">Select Report Type</option>
                                <option value="occupancy">Occupancy Report</option>
                                <option value="revenue">Revenue Report</option>
                                <option value="reservations">Reservations Report</option>
                            </select>
                            @error('report_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_range">Date Range</label>
                            <select class="form-control @error('date_range') is-invalid @enderror" id="date_range" name="date_range" required>
                                <option value="">Select Date Range</option>
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="last_7_days">Last 7 Days</option>
                                <option value="this_month">This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            @error('date_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3 custom-date-range" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateRangeSelect = document.getElementById('date_range');
        const customDateRange = document.querySelector('.custom-date-range');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        dateRangeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.style.display = 'flex';
                startDateInput.required = true;
                endDateInput.required = true;
            } else {
                customDateRange.style.display = 'none';
                startDateInput.required = false;
                endDateInput.required = false;
            }
        });

        // Set min date for end date when start date changes
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
        });
    });
</script>
@endsection
