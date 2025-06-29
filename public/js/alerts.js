$(document).ready(function() {
    // Function to format the time
    function timeAgo(date) {
        const seconds = Math.floor((new Date() - new Date(date)) / 1000);

        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + ' years ago';

        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + ' months ago';

        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + ' days ago';

        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + ' hours ago';

        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + ' minutes ago';

        return Math.floor(seconds) + ' seconds ago';
    }

    // Function to get alert icon based on type
    function getAlertIcon(type) {
        switch(type) {
            case 'success':
                return 'fa-check-circle text-success';
            case 'warning':
                return 'fa-exclamation-triangle text-warning';
            case 'danger':
                return 'fa-times-circle text-danger';
            default:
                return 'fa-info-circle text-info';
        }
    }

    // Function to load alerts
    function loadAlerts() {
        $.get('/alerts/unread-count', function(response) {
            const badge = $('#alerts-count');
            if (response.count > 0) {
                badge.text(response.count).show();
            } else {
                badge.hide();
            }
        });

        // Load alerts into dropdown
        $.get('/alerts', function(response) {
            const container = $('#alerts-container');
            container.empty();

            if (response.length === 0) {
                container.html(`
                    <div class="text-center py-3">
                        <i class="fas fa-bell-slash text-muted"></i>
                        <p class="text-muted mb-0">No new alerts</p>
                    </div>
                `);
                return;
            }

            response.forEach(alert => {
                container.append(`
                    <div class="dropdown-item alert-item" data-alert-id="${alert.id}">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas ${getAlertIcon(alert.type)} fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">${alert.title}</h6>
                                <p class="mb-0 small text-muted">${alert.message}</p>
                                <small class="text-muted">${timeAgo(alert.created_at)}</small>
                            </div>
                            ${!alert.is_read ? `
                                <button class="btn btn-sm text-primary mark-as-read" title="Mark as Read">
                                    <i class="fas fa-check"></i>
                                </button>
                            ` : ''}
                        </div>
                    </div>
                `);
            });
        });
    }

    // Load alerts on page load
    loadAlerts();

    // Refresh alerts every minute
    setInterval(loadAlerts, 60000);

    // Handle mark as read
    $(document).on('click', '.mark-as-read', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const alertItem = $(this).closest('.alert-item');
        const alertId = alertItem.data('alert-id');

        $.ajax({
            url: `/alerts/${alertId}/mark-as-read`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    loadAlerts();
                }
            }
        });
    });

    // Handle alert item click (for navigation)
    $(document).on('click', '.alert-item', function() {
        const link = $(this).data('link');
        if (link) {
            window.location.href = link;
        }
    });
});
