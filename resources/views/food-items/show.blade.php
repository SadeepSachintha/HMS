@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Food Item Details</h5>
                        <div>
                            <a href="{{ route('food-items.edit', $foodItem) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('food-items.index') }}" class="btn btn-secondary ms-2">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                @if($foodItem->image_path)
                                    <img src="{{ asset('storage/' . $foodItem->image_path) }}"
                                         alt="{{ $foodItem->name }}"
                                         class="img-fluid rounded"
                                         style="max-width: 300px;">
                                @else
                                    <div class="text-center p-4 bg-light rounded">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="mt-2 mb-0 text-muted">No image available</p>
                                    </div>
                                @endif
                            </div>

                            <table class="table">
                                <tr>
                                    <th style="width: 150px;">Name:</th>
                                    <td>{{ $foodItem->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $foodItem->category)) }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>LKR{{ number_format($foodItem->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge {{ $foodItem->is_available ? 'bg-success' : 'bg-danger' }}">
                                            {{ $foodItem->is_available ? 'Available' : 'Not Available' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Description</h6>
                                </div>
                                <div class="card-body">
                                    {{ $foodItem->description ?: 'No description available.' }}
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Ingredients</h6>
                                </div>
                                <div class="card-body">
                                    @if(is_array($foodItem->ingredients) && count($foodItem->ingredients) > 0)
                                        <ul class="list-unstyled mb-0">
                                            @foreach($foodItem->ingredients as $ingredient)
                                                <li class="mb-1">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    {{ $ingredient }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mb-0 text-muted">No ingredients listed.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
