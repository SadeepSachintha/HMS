@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Edit Room Type</h2>
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

                    <form action="{{ route('room-types.update', $roomType) }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $roomType->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="3">{{ old('description', $roomType->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price_per_night" class="form-label">Price Per Night</label>
                                    <div class="input-group">
                                        <span class="input-group-text">LKR</span>
                                        <input type="number" class="form-control @error('price_per_night') is-invalid @enderror"
                                               id="price_per_night" name="price_per_night"
                                               value="{{ old('price_per_night', $roomType->price_per_night) }}"
                                               step="0.01" min="0" required>
                                        @error('price_per_night')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                           id="capacity" name="capacity"
                                           value="{{ old('capacity', $roomType->capacity) }}"
                                           min="1" required>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Current Images</label>
                                    <div class="row g-2">
                                        @foreach($roomType->images as $image)
                                            <div class="col-6 position-relative">
                                                <div class="card">
                                                    <img src="{{ $image->image_url }}" class="card-img-top" alt="Room Type Image">
                                                    <div class="card-body p-2">
                                                        <input type="text" class="form-control form-control-sm mb-1"
                                                               name="image_captions[{{ $image->id }}]"
                                                               value="{{ $image->caption }}"
                                                               placeholder="Caption">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="number" class="form-control form-control-sm w-50"
                                                                   name="image_orders[{{ $image->id }}]"
                                                                   value="{{ $image->display_order }}"
                                                                   placeholder="Order">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="images" class="form-label">Add New Images</label>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                           id="images" name="images[]" multiple accept="image/*">
                                    <div class="form-text">You can select multiple images. Maximum 5 images allowed.</div>
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Room Amenities</label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_queen" name="amenities[]" value="queen"
                                                    {{ in_array('queen', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_queen">Queen Beds</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_double" name="amenities[]" value="double"
                                                    {{ in_array('double', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_double">Double Bed</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_single" name="amenities[]" value="single"
                                                    {{ in_array('single', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_single">Single Bed</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_bathroom" name="amenities[]" value="bathroom"
                                                    {{ in_array('bathroom', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_bathroom">Vanity with Sink</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_private_bathroom" name="amenities[]" value="private_bathroom"
                                                    {{ in_array('private_bathroom', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_private_bathroom">Private Bathroom</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_toiletries" name="amenities[]" value="toiletries"
                                                    {{ in_array('toiletries', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_toiletries">Toiletries</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_ac" name="amenities[]" value="ac"
                                                    {{ in_array('ac', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_ac">Air Conditioning</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_coffee" name="amenities[]" value="coffee"
                                                    {{ in_array('coffee', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_coffee">Coffee Maker</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_wifi" name="amenities[]" value="wifi"
                                                    {{ in_array('wifi', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_wifi">Free WIFI</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_hair_dryer" name="amenities[]" value="hair_dryer"
                                                    {{ in_array('hair_dryer', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_hair_dryer">Hair Dryer</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_tv" name="amenities[]" value="tv"
                                                    {{ in_array('tv', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_tv">LCD TV</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_fridge" name="amenities[]" value="fridge"
                                                    {{ in_array('fridge', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_fridge">Mini Refrigerator</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="amenity_desk" name="amenities[]" value="desk"
                                                    {{ in_array('desk', old('amenities', $roomType->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="amenity_desk">Work Desk</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('room-types.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Room Type</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .invalid-feedback {
        display: block;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    .input-group .form-control.is-invalid {
        z-index: 2;
    }
    .gap-2 {
        gap: 0.5rem !important;
    }
    .delete-image {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle image deletion
    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this image?')) {
                const imageId = this.dataset.imageId;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const basePath = window.location.pathname.substring(0, window.location.pathname.indexOf('/room-types/'));
                const fetchUrl = `${window.location.origin}${basePath}/room-types/images/${imageId}`;
                fetch(fetchUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.col-6').remove();
                    }
                });
            }
        });
    });

    // Preview new images before upload
    document.getElementById('images').addEventListener('change', function(e) {
        if (this.files.length > 5) {
            alert('You can only upload up to 5 images at once.');
            this.value = '';
            return;
        }
    });
});
</script>
@endpush
@endsection
