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
                        <h2 class="mb-0">User Details</h2>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h3 class="h4 mb-3">User Information</h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">User ID:</span> {{ $user->id }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">Name:</span> {{ $user->name }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">Email:</span> {{ $user->email }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">Role:</span> {{ $user->role }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">Status:</span>
                                            @if ($user->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-1"></i> Edit User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
