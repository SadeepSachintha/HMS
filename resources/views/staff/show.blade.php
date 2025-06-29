@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Staff Member Details</h4>
                        <div>
                            <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('staff.destroy', $staff) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <div class="avatar-circle mb-3">
                                    <span class="initials">{{ substr($staff->user->name, 0, 2) }}</span>
                                </div>
                                <h5>{{ $staff->user->name }}</h5>
                                <span class="badge bg-{{ $staff->status === 'active' ? 'success' : ($staff->status === 'inactive' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="30%">Email:</th>
                                        <td>{{ $staff->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $staff->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Position:</th>
                                        <td>{{ $staff->position }}</td>
                                    </tr>
                                    <tr>
                                        <th>Department:</th>
                                        <td>{{ $staff->department }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hire Date:</th>
                                        <td>{{ $staff->hire_date->format('F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Emergency Contact:</th>
                                        <td>{{ $staff->emergency_contact ?? 'Not provided' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($staff->events->count() > 0)
                    <div class="mt-4">
                        <h5>Assigned Events</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff->events as $event)
                                    <tr>
                                        <td>
                                            <a href="{{ route('events.show', $event) }}">
                                                {{ $event->name }}
                                            </a>
                                        </td>
                                        <td>{{ $event->start_time->format('M d, Y') }}</td>
                                        <td>{{ $event->pivot->role }}</td>
                                        <td>
                                            <span class="badge bg-{{ $event->status === 'scheduled' ? 'primary' : ($event->status === 'in_progress' ? 'warning' : ($event->status === 'completed' ? 'success' : 'danger')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $event->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.avatar-circle {
    width: 100px;
    height: 100px;
    background-color: #007bff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
}

.initials {
    font-size: 40px;
    line-height: 1;
    color: #ffffff;
    font-weight: bold;
    text-transform: uppercase;
}
</style>
@endsection
