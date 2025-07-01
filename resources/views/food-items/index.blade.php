@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Food Menu</h5>
                            <div class="d-flex align-items-center">
                                <form method="GET" action="{{ route('food-items.index') }}" class="d-flex me-3">
                                    <input type="text" name="search" class="form-control form-control-sm me-2"
                                        placeholder="Search by name, category, or description..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if (request('search'))
                                        <a href="{{ route('food-items.index') }}"
                                            class="btn btn-sm btn-outline-secondary ms-2">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </form>
                                <a href="{{ route('food-items.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Item
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (request('search'))
                            <div class="alert alert-info">
                                <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
                                <a href="{{ route('food-items.index') }}" class="float-end">Clear search</a>
                            </div>
                        @endif

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
                                                        <i class="fas fa-sort-up {{ request('sort') == 'name' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                        <i class="fas fa-sort-down {{ request('sort') == 'name' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center" style="height: 100%;">
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'order' => request('sort') == 'category' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                                    Category
                                                    <div class="d-flex flex-column">
                                                        <i class="fas fa-sort-up {{ request('sort') == 'category' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                        <i class="fas fa-sort-down {{ request('sort') == 'category' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center" style="height: 100%;">
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => request('sort') == 'price' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                                    Price
                                                    <div class="d-flex flex-column">
                                                        <i class="fas fa-sort-up {{ request('sort') == 'price' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                        <i class="fas fa-sort-down {{ request('sort') == 'price' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center" style="height: 100%;">
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'is_available', 'order' => request('sort') == 'is_available' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="text-decoration-none text-dark d-flex align-items-center justify-content-between w-100">
                                                    Status
                                                    <div class="d-flex flex-column">
                                                        <i class="fas fa-sort-up {{ request('sort') == 'is_available' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                        <i class="fas fa-sort-down {{ request('sort') == 'is_available' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                            style="font-size: 0.7em;"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="d-flex align-items-center" style="height: 100%;">Actions</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($foodItems as $item)
                                        <tr>
                                            <td class="align-middle">{{ $item->name }}</td>
                                            <td class="align-middle">{{ ucfirst(str_replace('_', ' ', $item->category)) }}</td>
                                            <td class="align-middle">${{ number_format($item->price, 2) }}</td>
                                            <td class="align-middle">
                                                <span class="badge {{ $item->is_available ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $item->is_available ? 'Available' : 'Not Available' }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('food-items.show', $item) }}"
                                                        class="btn btn-info btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('food-items.edit', $item) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('food-items.destroy', $item) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this food item?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-utensils fa-2x mb-3"></i>
                                                    <p class="mb-0">
                                                        @if (request('search'))
                                                            No food items found matching your search criteria.
                                                        @else
                                                            No food items found
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $foodItems->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
