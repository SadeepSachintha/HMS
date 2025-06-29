@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reservations</h5>
                    <div class="d-flex align-items-center">
                        <form method="GET" action="{{ route('reservations.index') }}" class="d-flex me-3">
                            <input type="text" name="search" class="form-control form-control-sm me-2"
                                   placeholder="Search by customer, room, or dates..."
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </form>
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary">New Reservation</a>
                    </div>
                </div>

                <div class="card-body">
                    @if(request('search'))
                        <div class="alert alert-info">
                            <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
                            <a href="{{ route('reservations.index') }}" class="float-end">Clear search</a>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('sort') == 'id' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            ID
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'id' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'id' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>Customer</th>
                                    <th>Room</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'check_in_date', 'order' => request('sort') == 'check_in_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Check In
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'check_in_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'check_in_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'check_out_date', 'order' => request('sort') == 'check_out_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Check Out
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'check_out_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'check_out_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'number_of_guests', 'order' => request('sort') == 'number_of_guests' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Guests
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'number_of_guests' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'number_of_guests' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('sort') == 'status' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Status
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'status' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'status' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->id }}</td>
                                        <td>{{ $reservation->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $reservation->room->number ?? 'N/A' }}</td>
                                        <td>{{ $reservation->check_in_date->format('Y-m-d') }}</td>
                                        <td>{{ $reservation->check_out_date->format('Y-m-d') }}</td>
                                        <td>{{ $reservation->number_of_guests }}</td>
                                        <td>
                                            <span class="badge bg-{{
                                                $reservation->status === 'confirmed' ? 'success' :
                                                ($reservation->status === 'pending' ? 'warning' :
                                                ($reservation->status === 'checked_in' ? 'info' :
                                                ($reservation->status === 'checked_out' ? 'secondary' :
                                                ($reservation->status === 'cancelled' ? 'danger' : 'secondary'))))
                                            }}">
                                                {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            @if(request('search'))
                                                No reservations found matching your search criteria.
                                            @else
                                                No reservations found.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $reservations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
