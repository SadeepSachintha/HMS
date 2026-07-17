@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Event Locations</h2>
        <a href="{{ route('event-locations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Location
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">Image</th>
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
                                            @if($location->image_path)
                                                <img src="{{ asset('storage/' . $location->image_path) }}" alt="{{ $location->name }}" class="img-fluid rounded" style="width: 80px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-secondary text-white rounded" style="width: 80px; height: 50px;">
                                                    <i class="fas fa-map-marker-alt" style="opacity: 0.6;"></i>
                                                </div>
                                            @endif
                                        </td>
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
                                                <a href="{{ route('event-locations.edit', $location) }}" class="btn btn-sm btn-primary d-inline-flex align-items-center" title="Edit">
                                                    <i class="fas fa-edit me-1"></i>
                                                </a>
                                                <form action="{{ route('event-locations.destroy', $location) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this location?')">
                                                        <i class="fas fa-trash me-1"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
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
