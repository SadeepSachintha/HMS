@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Create New Room</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rooms.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="number" class="form-label">Room Number</label>
                                <input type="text" class="form-control @error('number') is-invalid @enderror"
                                    id="number" name="number" value="{{ old('number') }}" required>
                                @error('number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="room_type_id" class="form-label">Room Type</label>
                                <select class="form-control @error('room_type_id') is-invalid @enderror" id="room_type_id"
                                    name="room_type_id" required>
                                    <option value="">Select Room Type</option>
                                    @foreach ($roomTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="floor" class="form-label">Floor</label>
                                <select class="form-control @error('floor') is-invalid @enderror" id="floor"
                                    name="floor" required>
                                    <option value="">Select Floor</option>
                                    <option value="1" {{ old('floor') == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ old('floor') == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('floor') == '3' ? 'selected' : '' }}>3</option>

                                </select>
                                @error('floor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>
                                        Available</option>
                                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied
                                    </option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                        Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Description</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Create Room</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
