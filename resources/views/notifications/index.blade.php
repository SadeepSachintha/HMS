@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Notifications</h2>
        @if($notifications->count() > 0)
            <button class="btn btn-secondary" id="mark-all-read">
                <i class="fas fa-check-double me-1"></i> Mark All as Read
            </button>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">

                <div class="card-body">
                    @if($notifications->count() > 0)
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item list-group-item-action {{ !$notification->is_read ? 'unread' : '' }}"
                                     id="notification-{{ $notification->id }}">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">
                                                <i class="fas fa-{{ $notification->type === 'success' ? 'check-circle text-success' :
                                                    ($notification->type === 'warning' ? 'exclamation-triangle text-warning' :
                                                    ($notification->type === 'error' ? 'times-circle text-danger' :
                                                    'info-circle text-info')) }} me-2"></i>
                                                {{ $notification->title }}
                                            </h5>
                                            <p class="mb-1">{{ $notification->message }}</p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="btn-group">
                                            @if(!$notification->is_read)
                                                <button class="btn btn-sm btn-outline-primary mark-as-read"
                                                        data-id="{{ $notification->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if($notification->link)
                                                <a href="{{ $notification->link }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif
                                            <button class="btn btn-sm btn-outline-danger delete-notification"
                                                    data-id="{{ $notification->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <p class="lead">No notifications found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const baseUrl = $('meta[name="base-url"]').attr('content') || '';

    // Mark single notification as read
    $('.mark-as-read').click(function() {
        const id = $(this).data('id');
        $.post(`${baseUrl}/notifications/${id}/mark-as-read`, {
            _token: '{{ csrf_token() }}'
        }).done(function() {
            $(`#notification-${id}`).removeClass('unread');
            $(`#notification-${id} .mark-as-read`).remove();
        });
    });

    // Mark all notifications as read
    $('#mark-all-read').click(function() {
        $.post(`${baseUrl}/notifications/mark-all-as-read`, {
            _token: '{{ csrf_token() }}'
        }).done(function() {
            $('.list-group-item').removeClass('unread');
            $('.mark-as-read').remove();
        });
    });

    // Delete notification
    $('.delete-notification').click(function() {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this notification?')) {
            $.ajax({
                url: `${baseUrl}/notifications/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                }
            }).done(function() {
                $(`#notification-${id}`).fadeOut(function() {
                    $(this).remove();
                    if ($('.list-group-item').length === 0) {
                        location.reload();
                    }
                });
            });
        }
    });
});
</script>
@endsection

@section('styles')
<style>
.unread {
    background-color: rgba(0, 123, 255, 0.05);
    font-weight: bold;
}
.list-group-item {
    transition: background-color 0.3s;
}
.list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
}
</style>
@endsection
