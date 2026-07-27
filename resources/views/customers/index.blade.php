@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Customers</h2>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('customers.index') }}" class="d-flex me-3">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                       placeholder="Search by name, email, phone, or ID..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Customer
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if(request('search'))
                <div class="alert alert-info">
                    <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
                    <a href="{{ route('customers.index') }}" class="float-end">Clear search</a>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="customersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('sort') == 'id' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    ID
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'id' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'id' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('sort') == 'name' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Name
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'name' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'name' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'order' => request('sort') == 'email' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Email
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'email' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'email' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'phone', 'order' => request('sort') == 'phone' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Phone
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'phone' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'phone' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nic_passport', 'order' => request('sort') == 'nic_passport' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    NIC / Passport No
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'nic_passport' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'nic_passport' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers ?? [] as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->nic_passport ?? '-' }}</td>
                            <td>
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                @if(request('search'))
                                    No customers found matching your search criteria.
                                @else
                                    No customers found.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#customersTable').DataTable({
            "paging": false,
            "searching": false,
            "info": false
        });
    });
</script>
@endsection
