@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">
                <i class="fa fa-arrow-left me-1"></i> Back to List
            </a>
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0"><i class="fa fa-user-plus me-2"></i>Add User</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-12">
                                <h3 class="h4 mb-3">User Information</h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold"><i class="fa fa-user fa-fw me-2"></i>Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold"><i class="fa fa-envelope fa-fw me-2"></i>Email</label>
                                        <input type="email" name="email" class="form-control" required autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold"><i class="fa fa-user-tag fa-fw me-2"></i>Role</label>
                                        <select name="role" class="form-control" required>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold"><i class="fa fa-toggle-on fa-fw me-2"></i>Status</label><br>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" value="1" checked>
                                            <label class="form-check-label" for="statusSwitch" id="statusSwitchLabel">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold"><i class="fa fa-key fa-fw me-2"></i>Password</label>
                                        <input type="password" name="password" class="form-control" required autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold"><i class="fa fa-key fa-fw me-2"></i>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Create User</button>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2"><i class="fa fa-times me-1"></i> Cancel</a>
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
