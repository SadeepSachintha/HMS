@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add New Food Item</h5>
                        <a href="{{ route('food-items.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('food-items.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
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
                                        <option value="appetizer" {{ old('category') == 'appetizer' ? 'selected' : '' }}>Appetizer</option>
                                        <option value="main_course" {{ old('category') == 'main_course' ? 'selected' : '' }}>Main Course</option>
                                        <option value="dessert" {{ old('category') == 'dessert' ? 'selected' : '' }}>Dessert</option>
                                        <option value="beverage" {{ old('category') == 'beverage' ? 'selected' : '' }}>Beverage</option>
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
                                               value="{{ old('price') }}"
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
                                              rows="3">{{ old('description') }}</textarea>
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
                                              placeholder="Enter ingredients, one per line">{{ old('ingredients') }}</textarea>
                                    <div class="form-text">Enter each ingredient on a new line</div>
                                    @error('ingredients')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*">
                                    <div class="form-text">Upload a square image for best results</div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input @error('is_available') is-invalid @enderror"
                                               id="is_available"
                                               name="is_available"
                                               value="1"
                                               {{ old('is_available', '1') == '1' ? 'checked' : '' }}>
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
                                <i class="fas fa-save"></i> Save Food Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
