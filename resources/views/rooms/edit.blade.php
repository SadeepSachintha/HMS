@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Edit Room</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('rooms.update', $room) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="number" class="form-label">Room Number</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror"
                                   id="number" name="number" value="{{ old('number', $room->number) }}" required>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="room_type_id" class="form-label">Room Type</label>
                            <select class="form-control @error('room_type_id') is-invalid @enderror"
                                    id="room_type_id" name="room_type_id" required>
                                <option value="">Select Room Type</option>
                                @foreach($roomTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ (old('room_type_id', $room->room_type_id) == $type->id) ? 'selected' : '' }}>
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
                            <input type="number" class="form-control @error('floor') is-invalid @enderror"
                                   id="floor" name="floor" value="{{ old('floor', $room->floor) }}" required>
                            @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Description</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                   id="notes" name="notes" rows="3">{{ old('notes', $room->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
