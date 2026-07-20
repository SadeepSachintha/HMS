@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">System Activity Logs</h2>
        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('activity-logs.export', request()->all()) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i> Export to Excel
            </a>
            <span class="badge bg-danger px-3 py-2 fs-6"><i class="fas fa-lock me-1"></i> Admin Access Only</span>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('activity-logs.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label text-muted small fw-bold">Search Keywords</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="search" name="search" class="form-control"
                               placeholder="Search by user, description, or action..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="action" class="form-label text-muted small fw-bold">Filter Action</label>
                    <select id="action" name="action" class="form-select">
                        <option value="">All Actions</option>
                        @foreach($actions as $actionOpt)
                            <option value="{{ $actionOpt }}" {{ request('action') == $actionOpt ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $actionOpt)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="date" class="form-label text-muted small fw-bold">Filter Date</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request('search') || request('action') || request('date'))
                        <a href="{{ route('activity-logs.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Logs Table Card -->
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Timestamp</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th class="pe-4">User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="ps-4 small text-nowrap">
                                    <span class="fw-bold">{{ $log->created_at->format('Y-m-d H:i:s') }}</span><br>
                                    <span class="text-muted small">({{ $log->created_at->diffForHumans() }})</span>
                                </td>
                                <td>
                                    @if($log->user)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-mini me-2 d-flex align-items-center justify-content-center bg-primary text-white rounded-circle fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                                {{ strtoupper(substr($log->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block">{{ $log->user->name }}</span>
                                                <span class="text-muted small d-block">{{ $log->user->email }}</span>
                                                <span class="badge bg-info mt-1" style="font-size: 0.7rem;">{{ ucfirst($log->user->role) }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted italic"><i class="fas fa-user-secret me-1"></i> System / Guest</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $actionClass = 'bg-secondary';
                                        if (in_array($log->action, ['created', 'store'])) {
                                            $actionClass = 'bg-success';
                                        } elseif (in_array($log->action, ['updated', 'update'])) {
                                            $actionClass = 'bg-warning text-dark';
                                        } elseif (in_array($log->action, ['deleted', 'destroy', 'failed_login'])) {
                                            $actionClass = 'bg-danger';
                                        } elseif ($log->action === 'login') {
                                            $actionClass = 'bg-primary';
                                        }
                                    @endphp
                                    <span class="badge {{ $actionClass }} px-2.5 py-1.5" style="font-size: 0.75rem;">
                                        {{ strtoupper(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td class="small" style="max-width: 300px; word-wrap: break-word;">
                                    <span class="fw-medium text-white">{{ $log->description }}</span>
                                </td>
                                <td class="small text-nowrap code-font">
                                    <code>{{ $log->ip_address ?? 'N/A' }}</code>
                                </td>
                                <td class="pe-4 small text-muted" style="max-width: 200px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;" title="{{ $log->user_agent }}">
                                    {{ $log->user_agent ?? 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-list-alt fa-3x mb-3 text-muted"></i>
                                        <h5 class="text-muted">No activity logs found</h5>
                                        <p class="mb-0">Try adjusting your filters or search keywords.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="d-flex justify-content-center py-4">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .avatar-mini {
        background-color: #3f51b5 !important;
        text-shadow: 0 1px 1px rgba(0,0,0,0.2);
    }
    code-font {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>
@endsection
