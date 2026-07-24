@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Alerts</h2>
        @if($alerts->count() > 0)
            <button class="btn btn-secondary" id="mark-all-read">
                <i class="fas fa-check-double me-1"></i> Mark All as Read
            </button>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">

                <div class="card-body">
                    @if($alerts->count() > 0)
                        <div class="list-group">
                            @foreach($alerts as $alert)
                                <div class="list-group-item list-group-item-action {{ !$alert->is_read ? 'unread' : '' }}"
                                     id="alert-{{ $alert->id }}">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">
                                                <i class="fas fa-{{ $alert->type === 'success' ? 'check-circle text-success' :
                                                    ($alert->type === 'warning' ? 'exclamation-triangle text-warning' :
                                                    ($alert->type === 'danger' ? 'times-circle text-danger' :
                                                    'info-circle text-info')) }} me-2"></i>
                                                {{ $alert->title }}
                                            </h5>
                                            <p class="mb-1">{{ $alert->message }}</p>
                                            <small class="text-muted">{{ $alert->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="btn-group">
                                            @if(!$alert->is_read)
                                                <button class="btn btn-sm btn-outline-primary mark-as-read"
                                                        data-alert-id="{{ $alert->id }}"
                                                        title="Mark as Read">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if($alert->link)
                                                <a href="{{ $alert->link }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="View Details">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif
                                            <button class="btn btn-sm btn-outline-danger delete-alert"
                                                    data-alert-id="{{ $alert->id }}"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $alerts->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No alerts to display</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .list-group-item.unread {
        background-color: #f8f9fa;
        border-left: 4px solid #007bff;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    .btn-group .btn i {
        width: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    const baseUrl = $('meta[name="base-url"]').attr('content') || '';

    // Mark single alert as read
    $('.mark-as-read').click(function() {
        const alertId = $(this).data('alert-id');
        const alertElement = $(`#alert-${alertId}`);

        $.ajax({
            url: `${baseUrl}/alerts/${alertId}/mark-as-read`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alertElement.removeClass('unread');
                    $(this).remove();
                    updateUnreadCount();
                }
            }.bind(this)
        });
    });

    // Mark all alerts as read
    $('#mark-all-read').click(function() {
        $.ajax({
            url: `${baseUrl}/alerts/mark-all-as-read`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('.list-group-item').removeClass('unread');
                    $('.mark-as-read').remove();
                    updateUnreadCount();
                }
            }
        });
    });

    // Delete alert
    $('.delete-alert').click(function() {
        if (!confirm('Are you sure you want to delete this alert?')) {
            return;
        }

        const alertId = $(this).data('alert-id');
        const alertElement = $(`#alert-${alertId}`);

        $.ajax({
            url: `${baseUrl}/alerts/${alertId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alertElement.fadeOut(300, function() {
                        $(this).remove();
                        if ($('.list-group-item').length === 0) {
                            location.reload();
                        }
                    });
                    updateUnreadCount();
                }
            }
        });
    });

    // Update unread count in navbar
    function updateUnreadCount() {
        $.get(baseUrl + '/alerts/unread-count', function(response) {
            const badge = $('#alerts-count');
            if (response.count > 0) {
                badge.text(response.count).show();
            } else {
                badge.hide();
            }
        });
    }
});
</script>
@endpush
