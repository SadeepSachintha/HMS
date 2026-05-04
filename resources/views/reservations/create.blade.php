@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Reservation</h5>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Back to List</a>
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

                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id" class="form-label">Customer</label>
                                    @if(isset($guestCustomer))
                                        <input type="text" class="form-control" value="{{ $guestCustomer->name }}" readonly>
                                        <input type="hidden" name="customer_id" value="{{ $guestCustomer->id }}">
                                    @else
                                        <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_id" class="form-label">Room</label>
                                    <select name="room_id" id="room_id" class="form-control @error('room_id') is-invalid @enderror" required disabled>
                                        <option value="">Select Dates First</option>
                                        {{-- Rooms will be populated dynamically via AJAX --}}
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
                                           id="check_in_date" name="check_in_date" value="{{ old('check_in_date') }}" required>
                                    @error('check_in_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_out_date" class="form-label">Check-out Date</label>
                                    <input type="date" class="form-control @error('check_out_date') is-invalid @enderror"
                                           id="check_out_date" name="check_out_date" value="{{ old('check_out_date') }}" required>
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
                                           id="number_of_guests" name="number_of_guests" value="{{ old('number_of_guests', 1) }}"
                                           min="1" required>
                                    @error('number_of_guests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    @if(auth()->user()->isGuest())
                                        <input type="text" class="form-control" value="Pending" readonly>
                                        <input type="hidden" name="status" value="pending">
                                    @else
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="checked_in" {{ old('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                            <option value="checked_out" {{ old('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Create Reservation</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date for check-in to today (creation only)
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('check_in_date').setAttribute('min', today);

        // Update check-out minimum and maximum date when check-in date changes
        document.getElementById('check_in_date').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(checkInDate.getDate() + 1);
            const maxDay = new Date(checkInDate);
            maxDay.setDate(checkInDate.getDate() + 14);
            document.getElementById('check_out_date').setAttribute('min', nextDay.toISOString().split('T')[0]);
            document.getElementById('check_out_date').setAttribute('max', maxDay.toISOString().split('T')[0]);
            fetchAvailableRooms();
        });
        
        document.getElementById('check_out_date').addEventListener('change', fetchAvailableRooms);

        // On page load, trigger change event if check-in date is already set
        const checkInInput = document.getElementById('check_in_date');
        if (checkInInput.value) {
            checkInInput.dispatchEvent(new Event('change'));
        }

        function fetchAvailableRooms() {
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;
            const roomSelect = document.getElementById('room_id');

            if (checkIn && checkOut) {
                roomSelect.innerHTML = '<option value="">Loading...</option>';
                roomSelect.disabled = true;

                fetch(`/reservations/available-rooms?check_in=${checkIn}&check_out=${checkOut}`)
                    .then(response => response.json())
                    .then(data => {
                        roomSelect.innerHTML = '<option value="">Select Room</option>';
                        data.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.id;
                            option.setAttribute('data-room-type', room.room_type.name);
                            option.setAttribute('data-capacity', room.room_type.capacity);
                            option.textContent = `Room ${room.number} (${room.room_type.name})`;
                            roomSelect.appendChild(option);
                        });
                        roomSelect.disabled = false;
                        updateMaxGuests(); // Update guest max based on new selection
                    })
                    .catch(error => {
                        console.error('Error fetching rooms:', error);
                        roomSelect.innerHTML = '<option value="">Error loading rooms</option>';
                    });
            } else {
                roomSelect.innerHTML = '<option value="">Select Dates First</option>';
                roomSelect.disabled = true;
            }
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
@endsection
