@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Create Room Type</h2>
                        <a href="{{ route('room-types.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('room-types.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Price Per Night <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">LKR</span>
                                <input type="number" step="0.01" min="0"
                                       class="form-control @error('price_per_night') is-invalid @enderror"
                                       id="price_per_night" name="price_per_night"
                                       value="{{ old('price_per_night') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control @error('capacity') is-invalid @enderror"
                                   id="capacity" name="capacity" value="{{ old('capacity') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amenities</label>
                            <div class="row g-3">
                                @php
                                    $amenities = [
                                        'queen' => 'Queen Bed',
                                        'single' => 'Single Bed',
                                        'double' => 'Double Bed',
                                        'bathroom' => 'Bathroom',
                                        'private_bathroom' => 'Private Bathroom',
                                        'toiletries' => 'Toiletries',
                                        'ac' => 'Air Conditioning',
                                        'coffee' => 'Coffee Maker',
                                        'wifi' => 'WiFi',
                                        'hair_dryer' => 'Hair Dryer',
                                        'tv' => 'TV',
                                        'fridge' => 'Mini Fridge',
                                        'desk' => 'Work Desk'
                                    ];
                                @endphp

                                @foreach($amenities as $value => $label)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="amenities[]" value="{{ $value }}"
                                                   id="amenity_{{ $value }}"
                                                   {{ (is_array(old('amenities')) && in_array($value, old('amenities'))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="amenity_{{ $value }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Images (Max 5)</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                   id="images" name="images[]" accept="image/*" multiple>
                            <div class="form-text">You can upload up to 5 images. Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB per image.</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Room Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .form-label {
        font-weight: 500;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endsection
@endsection
