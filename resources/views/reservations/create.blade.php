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
                                    <label for="check_in_date" class="form-label">Check-in Date</label>
                                    <input type="date" class="form-control @error('check_in_date') is-invalid @enderror"
                                           id="check_in_date" name="check_in_date" value="{{ old('check_in_date') }}" required>
                                    @error('check_in_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
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
                                    <label for="number_of_guests" class="form-label">Number of Guests</label>
                                    <input type="number" class="form-control @error('number_of_guests') is-invalid @enderror"
                                           id="number_of_guests" name="number_of_guests" value="{{ old('number_of_guests', 1) }}"
                                           min="1" required>
                                    @error('number_of_guests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- Hidden Status - Defaults to pending as requested --}}
                            <input type="hidden" name="status" value="pending">
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
                // Parse dates and validate to avoid race conditions or 422 validation errors when typing
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                
                // Ensure the years are fully entered (4 digits, e.g. >= 1000)
                if (isNaN(checkInDate.getTime()) || isNaN(checkOutDate.getTime()) || checkInDate.getFullYear() < 1000 || checkOutDate.getFullYear() < 1000) {
                    return; // user is still typing
                }

                // Check-out must be strictly after Check-in
                if (checkOutDate <= checkInDate) {
                    roomSelect.innerHTML = '<option value="">Select Dates First</option>';
                    roomSelect.disabled = true;
                    return;
                }

                roomSelect.innerHTML = '<option value="">Loading...</option>';
                roomSelect.disabled = true;

                // Dynamically resolve base path from current pathname to handle subdirectories correctly
                const basePath = window.location.pathname.substring(0, window.location.pathname.indexOf('/reservations/'));
                const fetchUrl = `${window.location.origin}${basePath}/reservations/available-rooms?check_in=${checkIn}&check_out=${checkOut}`;

                fetch(fetchUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
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
            if (!selectedOption || !selectedOption.value) {
                guestsInput.removeAttribute('max');
                return;
            }
            const roomType = selectedOption.getAttribute('data-room-type') || '';
            let maxGuests = parseInt(selectedOption.getAttribute('data-capacity')) || 1;
            if (roomType.toLowerCase() === 'single room') {
                maxGuests = 1;
            } else if (roomType.toLowerCase() === 'double room') {
                maxGuests = 2;
            } else if (roomType.toLowerCase() === 'deluxe family room') {
                maxGuests = 4;
            }
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
