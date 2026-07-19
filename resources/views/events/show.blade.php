@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/events.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid events-detail-card">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Event Details</h4>
                            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                <div>
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="30%">Event Name:</th>
                                            <td>{{ $event->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description:</th>
                                            <td>{{ $event->description }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Time:</th>
                                            <td>{{ $event->start_time->format('F d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>End Time:</th>
                                            <td>{{ $event->end_time->format('F d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Location:</th>
                                            <td>
                                                @if($event->location_id)
                                                    <a href="{{ route('event-locations.show', $event->location_id) }}" class="text-decoration-none">
                                                        {{ $event->location_rel->name ?? $event->location }}
                                                    </a>
                                                @else
                                                    {{ $event->location }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="30%">Customer:</th>
                                            <td>
                                                <a href="{{ route('customers.show', $event->customer) }}">
                                                    {{ $event->customer->name }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Max Attendees:</th>
                                            <td>{{ $event->max_attendees ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Price:</th>
                                            <td>LKR{{ number_format($event->price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $event->status === 'scheduled' ? 'primary' : ($event->status === 'in_progress' ? 'warning' : ($event->status === 'completed' ? 'success' : 'danger')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $event->status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Notes:</th>
                                            <td>{{ $event->notes ?? 'No notes' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($event->staff->count() > 0)
                            <div class="mt-4">
                                <h5>Assigned Staff</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Department</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($event->staff as $staff)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('staff.show', $staff) }}">
                                                            {{ $staff->user->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $staff->position }}</td>
                                                    <td>{{ $staff->department }}</td>
                                                    <td>{{ $staff->pivot->role }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <a href="{{ route('events.index') }}" class="btn btn-secondary mb-3">
                    &larr; Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Assign Staff Modal -->
    <div class="modal fade" id="assignStaffModal" tabindex="-1" aria-labelledby="assignStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('events.staff.assign', $event) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignStaffModalLabel">Assign Staff to Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staff_id" class="form-label">Staff Member</label>
                            <select class="form-select" id="staff_id" name="staff_id" required>
                                <option value="">Select Staff Member</option>
                                @foreach ($availableStaff as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->position }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role in Event</label>
                            <input type="text" class="form-control" id="role" name="role" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
