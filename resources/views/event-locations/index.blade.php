@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Event Locations</h2>
        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
            <a href="{{ route('event-locations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Location
            </a>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Capacity</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($locations as $location)
                                    <tr>
                                        <td class="align-middle">
                                            <a href="{{ route('event-locations.show', $location) }}" class="text-decoration-none fw-bold">
                                                {{ $location->name }}
                                            </a>
                                        </td>
                                        <td class="align-middle">{{ $location->capacity ?? 'N/A' }}</td>
                                        <td class="align-middle">{{ Str::limit($location->description, 50) }}</td>
                                        <td class="align-middle">
                                            @if($location->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2">
                                                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                                    <a href="{{ route('event-locations.edit', $location) }}" class="btn btn-sm btn-primary d-inline-flex align-items-center" title="Edit">
                                                        <i class="fas fa-edit me-1"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No locations found</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $locations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
