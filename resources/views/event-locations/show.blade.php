@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Location Details</h5>
                    <a href="{{ route('event-locations.edit', $eventLocation) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    <h3 class="card-title text-primary">{{ $eventLocation->name }}</h3>
                    <hr>
                    <p><strong>Capacity:</strong> {{ $eventLocation->capacity ?? 'Not specified' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $eventLocation->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($eventLocation->status) }}
                        </span>
                    </p>
                    <p><strong>Description:</strong></p>
                    <p class="text-muted">{{ $eventLocation->description ?? 'No description provided.' }}</p>
                </div>
            </div>
            
            <a href="{{ route('event-locations.index') }}" class="btn btn-secondary w-100">
                <i class="fas fa-arrow-left"></i> Back to Locations
            </a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Events at this Location</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($eventLocation->events as $event)
                                    <tr>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->start_time->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $event->status === 'scheduled' ? 'primary' : ($event->status === 'in_progress' ? 'warning' : ($event->status === 'completed' ? 'success' : 'danger')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $event->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            No events scheduled for this location.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
