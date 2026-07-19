@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title mb-0">Food Menu</h2>
            <div class="d-flex align-items-center">
                <form method="GET" action="{{ route('food-items.index') }}" class="d-flex me-3">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Search by name, category, or description..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    @if (request('search'))
                        <a href="{{ route('food-items.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>
                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                    <a href="{{ route('food-items.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add New Item
                    </a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (request('search'))
                            <div class="alert alert-info">
                                <i class="fas fa-search text-primary"></i> Search results for:
                                <strong>"{{ request('search') }}"</strong>
                                <a href="{{ route('food-items.index') }}" class="float-end">Clear search</a>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('sort') == 'id' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                                class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                                ID
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'id' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'id' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </th>

                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('sort') == 'name' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                                class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                                Name
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'name' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'name' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'order' => request('sort') == 'category' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                                class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                                Category
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'category' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'category' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => request('sort') == 'price' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                                class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                                Price
                                                <div class="d-flex flex-column">
                                                    <i class="fas fa-sort-up {{ request('sort') == 'price' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                    <i class="fas fa-sort-down {{ request('sort') == 'price' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}"
                                                        style="font-size: 0.7em;"></i>
                                                </div>
                                            </a>
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($foodItems as $item)
                                        <tr>
                                            <td class="align-middle">{{ $item->id }}</td>

                                            <td class="align-middle fw-bold">{{ $item->name }}</td>
                                            <td class="align-middle">{{ $item->category }}</td>
                                            <td class="align-middle text-primary fw-bold">
                                                LKR{{ number_format($item->price, 2) }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('food-items.show', $item) }}"
                                                        class="btn btn-info btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                                                        <a href="{{ route('food-items.edit', $item) }}"
                                                            class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
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
