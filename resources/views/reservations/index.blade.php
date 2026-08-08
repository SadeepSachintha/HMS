@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">{{ auth()->user()->isGuest() ? 'My Reservations' : 'Reservations' }}</h2>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('reservations.index') }}" class="d-flex me-3">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                       placeholder="Search by customer, room, or dates..."
                       value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm me-2" style="width: auto;">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('reservations.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>New Reservation</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if(request('search') || request('status'))
                        <div class="alert alert-info">
                            <i class="fas fa-search"></i>
                            @if(request('search') && request('status'))
                                Search results for: <strong>"{{ request('search') }}"</strong> with status: <strong>"{{ ucfirst(request('status')) }}"</strong>
                            @elseif(request('search'))
                                Search results for: <strong>"{{ request('search') }}"</strong>
                            @elseif(request('status'))
                                Filtered by status: <strong>"{{ ucfirst(request('status')) }}"</strong>
                            @endif
                            <a href="{{ route('reservations.index') }}" class="float-end">Clear filters</a>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('sort') == 'id' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none d-flex align-items-center justify-content-between">
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
                                           class="text-decoration-none d-flex align-items-center justify-content-between">
                                            Check In
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'check_in_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'check_in_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'check_out_date', 'order' => request('sort') == 'check_out_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none d-flex align-items-center justify-content-between">
                                            Check Out
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'check_out_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'check_out_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'number_of_guests', 'order' => request('sort') == 'number_of_guests' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none d-flex align-items-center justify-content-between">
                                            Guests
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'number_of_guests' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'number_of_guests' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('sort') == 'status' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none d-flex align-items-center justify-content-between">
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
                                                strtolower($reservation->status) === 'confirmed' ? 'success' :
                                                (strtolower($reservation->status) === 'pending' ? 'warning' :
                                                (strtolower($reservation->status) === 'checked_in' ? 'info' :
                                                (strtolower($reservation->status) === 'checked_out' ? 'secondary' :
                                                (strtolower($reservation->status) === 'cancelled' ? 'danger' : 'secondary'))))
                                            }}">
                                                {{ ucfirst(strtolower(str_replace('_', ' ', $reservation->status))) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!auth()->user()->isGuest())
                                                     @if($reservation->invoice && $reservation->invoice->status !== 'paid')
                                                         <a href="{{ route('payments.create', ['invoice_id' => $reservation->invoice->id]) }}" class="btn btn-sm btn-success" title="Record Payment">
                                                             <i class="fas fa-money-bill-wave"></i>
                                                         </a>
                                                     @endif
                                                     @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                                         <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-primary" title="Edit">
                                                             <i class="fas fa-edit"></i>
                                                         </a>
                                                     @endif
                                                 @endif
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

@section('scripts')
<script>
$(document).ready(function() {
    $('select[name="status"]').on('change', function() {
        $(this).closest('form').submit();
    });
});
</script>
