@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Rooms</h2>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('rooms.index') }}" class="d-flex me-3">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                       placeholder="Search by number, type, or floor..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Room
            </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    @if(request('search'))
                        <div class="alert alert-info">
                            <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
                            <a href="{{ route('rooms.index') }}" class="float-end">Clear search</a>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover" id="rooms-table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="d-flex align-items-center" style="height: 100%;">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'number', 'order' => request('sort') == 'number' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                               class="text-decoration-none d-flex align-items-center justify-content-between w-100">
                                                Room Number
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'number' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'number' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </th>
                                    <th><div class="d-flex align-items-center" style="height: 100%;">Type</div></th>
                                    <th>
                                        <div class="d-flex align-items-center" style="height: 100%;">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'floor', 'order' => request('sort') == 'floor' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                               class="text-decoration-none d-flex align-items-center justify-content-between w-100">
                                                Floor
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'floor' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'floor' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="d-flex align-items-center" style="height: 100%;">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('sort') == 'status' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                               class="text-decoration-none d-flex align-items-center justify-content-between w-100">
                                                Status
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'status' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'status' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </th>
                                    <th><div class="d-flex align-items-center" style="height: 100%;">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rooms as $room)
                                    <tr data-room-id="{{ $room->id }}">
                                        <td class="align-middle">{{ $room->number }}</td>
                                        <td class="align-middle">{{ $room->roomType->name ?? 'N/A' }}</td>
                                        <td class="align-middle">{{ $room->floor }}</td>
                                        <td class="align-middle">
                                            @if($room->status)
                                                @switch($room->status)
                                                    @case('available')
                                                        <span class="badge bg-success">Available</span>
                                                        @break
                                                    @case('occupied')
                                                        <span class="badge bg-danger">Occupied</span>
                                                        @break
                                                    @case('maintenance')
                                                        <span class="badge bg-warning text-dark">Maintenance</span>
                                                        @break
                                                    @case('reserved')
                                                        <span class="badge bg-info">Reserved</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($room->status) }}</span>
                                                @endswitch
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-info text-white d-inline-flex align-items-center" title="View">
                                                    <i class="fas fa-eye me-1"></i>
                                                </a>
                                                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-primary d-inline-flex align-items-center" title="Edit">
                                                    <i class="fas fa-edit me-1"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="no-rooms-row">
                                        <td colspan="5" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">
                                                    @if(request('search'))
                                                        No rooms found matching your search criteria.
                                                    @else
                                                        No rooms found
                                                    @endif
                                                </h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $rooms->links() }}
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
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
@endsection

@push('scripts')
<script src="{{ asset('js/vendor/pusher.min.js') }}"></script>
<script>
    // Initialize Pusher
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    // Subscribe to the rooms channel
    const channel = pusher.subscribe('rooms');

    // Handle room events
    channel.bind('App\\Events\\RoomEvent', function(data) {
        const room = data.room;
        const action = data.action;
        const tableBody = document.querySelector('#rooms-table tbody');
        const noRoomsRow = document.querySelector('#no-rooms-row');

        switch(action) {
            case 'created':
                if (noRoomsRow) {
                    noRoomsRow.remove();
                }

                const newRow = createRoomRow(room);
                tableBody.insertBefore(newRow, tableBody.firstChild);
                fadeIn(newRow);
                break;

            case 'updated':
                const existingRow = document.querySelector(`tr[data-room-id="${room.id}"]`);
                if (existingRow) {
                    const updatedRow = createRoomRow(room);
                    existingRow.replaceWith(updatedRow);
                    fadeIn(updatedRow);
                }
                break;

            case 'deleted':
                const rowToDelete = document.querySelector(`tr[data-room-id="${room.id}"]`);
                if (rowToDelete) {
                    fadeOut(rowToDelete, () => {
                        rowToDelete.remove();
                        if (tableBody.children.length === 0) {
                            tableBody.innerHTML = createNoRoomsRow();
                        }
                    });
                }
                break;
        }
    });

    // Helper function to create a new room row
    function createRoomRow(room) {
        const tr = document.createElement('tr');
        tr.setAttribute('data-room-id', room.id);

        // Helper function to get status badge HTML
        function getStatusBadge(status) {
            if (!status) {
                return '<span class="badge bg-secondary">Unknown</span>';
            }

            switch(status) {
                case 'available':
                    return '<span class="badge bg-success">Available</span>';
                case 'occupied':
                    return '<span class="badge bg-danger">Occupied</span>';
                case 'maintenance':
                    return '<span class="badge bg-warning text-dark">Maintenance</span>';
                case 'reserved':
                    return '<span class="badge bg-info">Reserved</span>';
                default:
                    return `<span class="badge bg-secondary">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
            }
        }

        tr.innerHTML = `
            <td class="align-middle">${room.number}</td>
            <td class="align-middle">${room.room_type ? room.room_type.name : 'N/A'}</td>
            <td class="align-middle">${room.floor}</td>
            <td class="align-middle">${getStatusBadge(room.status)}</td>
            <td class="align-middle">
                <div class="d-flex gap-2">
                    <a href="/rooms/${room.id}" class="btn btn-sm btn-info text-white d-inline-flex align-items-center" title="View">
                        <i class="fas fa-eye me-1"></i>
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                    <a href="/rooms/${room.id}/edit" class="btn btn-sm btn-primary d-inline-flex align-items-center" title="Edit">
                        <i class="fas fa-edit me-1"></i>
                    </a>
                    @endif
                </div>
            </td>
        `;

        return tr;
    }

    // Helper function to create the "No rooms found" row
    function createNoRoomsRow() {
        return `
            <tr id="no-rooms-row">
                <td colspan="5" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No rooms found</h5>
                    </div>
                </td>
            </tr>
        `;
    }

    // Animation helpers
    function fadeIn(element) {
        element.style.opacity = 0;
        let opacity = 0;
        const timer = setInterval(() => {
            opacity += 0.1;
            element.style.opacity = opacity;
            if (opacity >= 1) {
                clearInterval(timer);
            }
        }, 50);
    }

    function fadeOut(element, callback) {
        let opacity = 1;
        const timer = setInterval(() => {
            opacity -= 0.1;
            element.style.opacity = opacity;
            if (opacity <= 0) {
                clearInterval(timer);
                if (callback) callback();
            }
        }, 50);
    }
</script>
@endpush
@endsection
