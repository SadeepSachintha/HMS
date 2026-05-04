@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Edit User</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h3 class="h4 mb-3">User Information</h3>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="fw-bold">Name</label>
                                            <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fw-bold">Email</label>
                                            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fw-bold">Role</label>
                                            <select name="role" class="form-control" required>
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fw-bold">Status</label><br>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" value="1" {{ old('status', $user->status) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusSwitch" id="statusSwitchLabel">
                                                    {{ old('status', $user->status) ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update User</button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2"><i class="fas fa-times me-1"></i> Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var statusSwitch = document.getElementById('statusSwitch');
            var statusLabel = document.getElementById('statusSwitchLabel');
            if(statusSwitch && statusLabel) {
                statusSwitch.addEventListener('change', function() {
                    statusLabel.textContent = statusSwitch.checked ? 'Active' : 'Inactive';
                });
            }
        });
    </script>
@endsection
