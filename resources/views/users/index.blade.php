@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <h2 class="mb-0"><i class="fa fa-users me-2"></i>User Management</h2>
                    <form method="GET" action="" class="d-flex align-items-center gap-2 ms-auto">
                        <input type="text" name="search" class="form-control me-2" style="min-width: 250px;" placeholder="Search by name, email, role..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <a href="{{ route('users.create') }}" class="btn btn-primary ms-2"><i class="fa fa-plus me-1"></i> Add User</a>
                </div>
                <div class="card-body">
                    <h3 class="h4 mb-3">User List</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="fa fa-id-badge me-1"></i>User ID</th>
                                    <th><i class="fa fa-user-tag me-1"></i>User Role</th>
                                    <th><i class="fa fa-user me-1"></i>Name</th>
                                    <th><i class="fa fa-toggle-on me-1"></i>Status</th>
                                    <th><i class="fa fa-cogs me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if($user->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                        <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="d-inline ms-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $user->status ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                    title="{{ $user->status ? 'Deactivate' : 'Activate' }} user">
                                                <i class="fa {{ $user->status ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info me-1" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary me-1" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $user->id }}" title="Reset Password"><i class="fa fa-key"></i></button>
                                        <!-- Reset Password Modal -->
                                        <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel{{ $user->id }}" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form method="POST" action="{{ route('users.reset-password', $user) }}">
                                                @csrf
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="resetPasswordModalLabel{{ $user->id }}">Reset Password</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="mb-3">
                                                    <label class="form-label">New Password</label>
                                                    <input type="password" name="password" class="form-control" required>
                                                  </div>
                                                  <div class="mb-3">
                                                    <label class="form-label">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control" required>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" class="btn btn-primary">Reset</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center">No users found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
