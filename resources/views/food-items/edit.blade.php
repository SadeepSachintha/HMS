@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Food Item</h5>
                        <a href="{{ route('food-items.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('food-items.update', $foodItem) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $foodItem->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control @error('category') is-invalid @enderror"
                                            id="category"
                                            name="category"
                                            required>
                                        <option value="">Select Category</option>
                                        <option value="appetizer" {{ old('category', $foodItem->category) == 'appetizer' ? 'selected' : '' }}>Appetizer</option>
                                        <option value="main_course" {{ old('category', $foodItem->category) == 'main_course' ? 'selected' : '' }}>Main Course</option>
                                        <option value="dessert" {{ old('category', $foodItem->category) == 'dessert' ? 'selected' : '' }}>Dessert</option>
                                        <option value="beverage" {{ old('category', $foodItem->category) == 'beverage' ? 'selected' : '' }}>Beverage</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">LKR</span>
                                        <input type="number"
                                               class="form-control @error('price') is-invalid @enderror"
                                               id="price"
                                               name="price"
                                               value="{{ old('price', $foodItem->price) }}"
                                               step="0.01"
                                               min="0"
                                               required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="3">{{ old('description', $foodItem->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ingredients" class="form-label">Ingredients</label>
                                    <textarea class="form-control @error('ingredients') is-invalid @enderror"
                                              id="ingredients"
                                              name="ingredients"
                                              rows="3"
                                              placeholder="Enter ingredients, one per line">{{ old('ingredients', is_array($foodItem->ingredients) ? implode("\n", $foodItem->ingredients) : $foodItem->ingredients) }}</textarea>
                                    <div class="form-text">Enter each ingredient on a new line</div>
                                    @error('ingredients')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    @if($foodItem->image_path)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $foodItem->image_path) }}"
                                                 alt="{{ $foodItem->name }}"
                                                 class="img-thumbnail"
                                                 style="max-width: 150px;">
                                        </div>
                                    @endif
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*">
                                    <div class="form-text">Upload a new image to replace the existing one</div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="hidden" name="is_available" value="0">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input @error('is_available') is-invalid @enderror"
                                               id="is_available"
                                               name="is_available"
                                               value="1"
                                               {{ old('is_available', $foodItem->is_available) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_available">Available for Order</label>
                                        @error('is_available')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Food Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
