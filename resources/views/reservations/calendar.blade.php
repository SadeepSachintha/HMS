@extends('layouts.app')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        font-weight: 500;
    }
    .fc-event:hover {
        opacity: 0.8;
        transform: scale(1.02);
        transition: all 0.2s ease;
    }
    .room-filter {
        margin-bottom: 20px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 600;
    }
    .fc-button-primary {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }
    .fc-button-primary:hover {
        background-color: #0b5ed7 !important;
        border-color: #0a58ca !important;
    }
    .fc-daygrid-day.fc-day-today {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .reservation-status-badge {
        display: inline-block;
        padding: 0.25em 0.6em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.375rem;
        text-transform: uppercase;
    }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-confirmed { background-color: #d1e7dd; color: #0f5132; }
    .status-checked_in { background-color: #cff4fc; color: #055160; }
    .status-checked_out { background-color: #e2e3e5; color: #41464b; }
    .status-cancelled { background-color: #f8d7da; color: #721c24; }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .modal-header .btn-close {
        filter: invert(1);
    }
    .reservation-details p {
        margin-bottom: 0.75rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .reservation-details p:last-child {
        border-bottom: none;
    }
    .reservation-details strong {
        color: #495057;
        min-width: 120px;
        display: inline-block;
    }
    #calendar {
        min-height: 600px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        padding: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Reservations Calendar
                        </h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('reservations.create') }}" class="btn btn-light">
                                <i class="fas fa-plus me-1"></i> New Reservation
                            </a>
                            <a href="{{ route('reservations.index') }}" class="btn btn-outline-light">
                                <i class="fas fa-list me-1"></i> List View
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="room-filter">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label for="room-select" class="form-label fw-bold">
                                    <i class="fas fa-filter me-1"></i>Filter by Room:
                                </label>
                                <select id="room-select" class="form-select">
                                    <option value="">All Rooms</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">
                                            Room {{ $room->number }} ({{ $room->roomType->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    <span class="badge bg-success">Confirmed</span>
                                    <span class="badge bg-info">Checked In</span>
                                    <span class="badge bg-secondary">Checked Out</span>
                                    <span class="badge bg-danger">Cancelled</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reservation Details Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Reservation Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="reservation-details">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Customer:</strong> <span id="customer-name"></span></p>
                            <p><strong>Room:</strong> <span id="room-number"></span></p>
                            <p><strong>Room Type:</strong> <span id="room-type"></span></p>
                            <p><strong>Check-in:</strong> <span id="check-in-date"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Check-out:</strong> <span id="check-out-date"></span></p>
                            <p><strong>Guests:</strong> <span id="number-of-guests"></span></p>
                            <p><strong>Status:</strong> <span id="reservation-status"></span></p>
                            <p><strong>Duration:</strong> <span id="duration"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="edit-reservation" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Reservation
                </a>
                <a href="#" id="view-reservation" class="btn btn-info text-white">
                    <i class="fas fa-eye me-1"></i> View Details
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        alert('Calendar element not found!');
        return;
    }
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth'
    });
    calendar.render();
    console.log('FullCalendar rendered!');
});
</script>
@endsection
