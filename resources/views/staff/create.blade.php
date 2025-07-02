@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add New Staff Member</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select @error('department') is-invalid @enderror" id="department" name="department" required>
                                <option value="">Select Department</option>
                                <option value="Front Office" {{ old('department') == 'Front Office' ? 'selected' : '' }}>Front Office</option>
                                <option value="Housekeeping" {{ old('department') == 'Housekeeping' ? 'selected' : '' }}>Housekeeping</option>
                                <option value="Food & Beverage" {{ old('department') == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                                <option value="Maintenance" {{ old('department') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Security" {{ old('department') == 'Security' ? 'selected' : '' }}>Security</option>
                                <option value="Kitchen" {{ old('department') == 'Kitchen' ? 'selected' : '' }}>Kitchen</option>
                                <option value="Laundry" {{ old('department') == 'Laundry' ? 'selected' : '' }}>Laundry</option>
                                <option value="IT" {{ old('department') == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="Events" {{ old('department') == 'Events' ? 'selected' : '' }}>Events</option>
                                <option value="Human Resources" {{ old('department') == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                                <option value="Other" {{ old('department') == 'Other' ? 'selected' : '' }}>Other</option>
                                <option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Administration</option>
                            </select>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hire_date" class="form-label">Hire Date</label>
                            <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                            @error('hire_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary') }}" placeholder="Enter salary amount">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="emergency_contact" class="form-label">Emergency Contact</label>
                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" placeholder="Emergency contact information">
                            @error('emergency_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Staff Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
