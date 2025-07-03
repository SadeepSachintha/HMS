@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Room Types</h2>
                        <a href="{{ route('room-types.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add New Room Type
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <div class="d-flex align-items-center" style="height: 100%;">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('sort') == 'name' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                               class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                                Name
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'name' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'name' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </th>
                                    <th><div class="d-flex align-items-center" style="height: 100%;">Description</div></th>
                                    <th>
                                        <div class="d-flex align-items-center" style="height: 100%;">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_per_night', 'order' => request('sort') == 'price_per_night' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                               class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                                Price Per Night
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'price_per_night' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'price_per_night' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </th>
                                    <th><div class="d-flex align-items-center" style="height: 100%;">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomTypes as $roomType)
                                    <tr>
                                        <td class="align-middle">{{ $roomType->name }}</td>
                                        <td class="align-middle">{{ $roomType->description }}</td>
                                        <td class="align-middle">${{ number_format($roomType->price_per_night, 2) }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('room-types.show', $roomType) }}" class="btn btn-sm btn-info text-white d-inline-flex align-items-center" title="View">
                                                    <i class="fas fa-eye me-1"></i>
                                                </a>
                                                <a href="{{ route('room-types.edit', $roomType) }}" class="btn btn-sm btn-primary d-inline-flex align-items-center" title="Edit">
                                                    <i class="fas fa-edit me-1"></i>
                                                </a>
                                                <form action="{{ route('room-types.destroy', $roomType) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center"
                                                            onclick="return confirm('Are you sure you want to delete this room type?')">
                                                        <i class="fas fa-trash me-1"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No room types found</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $roomTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .btn-group .btn {
        margin-right: 0;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.75em;
    }
    .badge.rounded-pill {
        padding-right: 0.8em;
        padding-left: 0.8em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }
    .d-inline-flex {
        display: inline-flex !important;
    }
    .align-items-center {
        align-items: center !important;
    }
</style>
@endsection
@endsection
