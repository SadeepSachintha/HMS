@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Reservation</h1>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary mb-3">Back to List</a>
    <form action="{{ route('reservations.update', $reservation) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $reservation->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="room_id" class="form-label">Room</label>
                    <select name="room_id" id="room_id" class="form-control @error('room_id') is-invalid @enderror" required>
                        <option value="">Select Room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-room-type="{{ $room->roomType->name }}" data-capacity="{{ $room->roomType->capacity }}" {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                                Room {{ $room->number }} ({{ $room->roomType->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="check_in_date" class="form-label">Check-in Date</label>
                    <input type="date" class="form-control @error('check_in_date') is-invalid @enderror"
                           id="check_in_date" name="check_in_date" value="{{ old('check_in_date', $reservation->check_in_date ? $reservation->check_in_date->format('Y-m-d') : '') }}" required>
                    @error('check_in_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="check_out_date" class="form-label">Check-out Date</label>
                    <input type="date" class="form-control @error('check_out_date') is-invalid @enderror"
                           id="check_out_date" name="check_out_date" value="{{ old('check_out_date', $reservation->check_out_date ? $reservation->check_out_date->format('Y-m-d') : '') }}" required>
                    @error('check_out_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="number_of_guests" class="form-label">Number of Guests</label>
                    <input type="number" class="form-control @error('number_of_guests') is-invalid @enderror"
                           id="number_of_guests" name="number_of_guests" value="{{ old('number_of_guests', $reservation->number_of_guests) }}"
                           min="1" required>
                    @error('number_of_guests')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $reservation->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked_in" {{ old('status', $reservation->status) == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="checked_out" {{ old('status', $reservation->status) == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Reservation</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Remove min restriction for check-in date on edit
        // (No code to set min for check_in_date)

        // Update check-out minimum and maximum date when check-in date changes
        document.getElementById('check_in_date').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(checkInDate.getDate() + 1);
            const maxDay = new Date(checkInDate);
            maxDay.setDate(checkInDate.getDate() + 14);
            document.getElementById('check_out_date').setAttribute('min', nextDay.toISOString().split('T')[0]);
            document.getElementById('check_out_date').setAttribute('max', maxDay.toISOString().split('T')[0]);
        });
        // On page load, trigger change event if check-in date is already set
        const checkInInput = document.getElementById('check_in_date');
        if (checkInInput.value) {
            checkInInput.dispatchEvent(new Event('change'));
        }

        // Room type max guests logic
        const roomSelect = document.getElementById('room_id');
        const guestsInput = document.getElementById('number_of_guests');
        function updateMaxGuests() {
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const maxGuests = parseInt(selectedOption.getAttribute('data-capacity')) || 1;
            guestsInput.max = maxGuests;
            if (parseInt(guestsInput.value) > maxGuests) {
                guestsInput.value = maxGuests;
            }
        }
        roomSelect.addEventListener('change', updateMaxGuests);
        // Run on page load in case of old value
        updateMaxGuests();
    });
</script>
@endpush
