@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Staff Management</h2>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('staff.index') }}" class="d-flex me-3">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                       placeholder="Search by name, position, or department..."
                       value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm me-2" style="width: auto;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                </select>
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('staff.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('staff.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Staff
            </a>
        </div>
    </div>

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
            <a href="{{ route('staff.index') }}" class="float-end">Clear filters</a>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <div class="d-flex align-items-center" style="height: 100%;">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('sort') == 'id' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                        ID
                                        <div class="d-flex flex-column">
                                            <i class="fas fa-sort-up {{ request('sort') == 'id' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            <i class="fas fa-sort-down {{ request('sort') == 'id' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        </div>
                                    </a>
                                </div>
                            </th>
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
                            <th>
                                <div class="d-flex align-items-center" style="height: 100%;">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'position', 'order' => request('sort') == 'position' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                        Position
                                        <div class="d-flex flex-column">
                                            <i class="fas fa-sort-up {{ request('sort') == 'position' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            <i class="fas fa-sort-down {{ request('sort') == 'position' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        </div>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center" style="height: 100%;">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'department', 'order' => request('sort') == 'department' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                        Department
                                        <div class="d-flex flex-column">
                                            <i class="fas fa-sort-up {{ request('sort') == 'department' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            <i class="fas fa-sort-down {{ request('sort') == 'department' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        </div>
                                    </a>
                                </div>
                            </th>
                            <th><div class="d-flex align-items-center" style="height: 100%;">Phone</div></th>
                            <th>
                                <div class="d-flex align-items-center" style="height: 100%;">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('sort') == 'status' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
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
                        @forelse($staff as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->position }}</td>
                                <td>{{ $member->department }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>
                                    <span class="badge bg-{{ $member->status === 'active' ? 'success' : ($member->status === 'inactive' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('staff.show', $member) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('staff.edit', $member) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('staff.destroy', $member) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    @if(request('search') || request('status'))
                                        No staff members found matching your criteria.
                                    @else
                                        No staff members found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $staff->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
