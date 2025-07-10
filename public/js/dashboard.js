// Initialize Pusher
const pusher = new Pusher(window.pusherKey, {
    cluster: window.pusherCluster,
    encrypted: true
});

// Subscribe to the dashboard-stats channel
const channel = pusher.subscribe('dashboard-stats');

// Handle stats updates
channel.bind('App\\Events\\DashboardStatsEvent', function(data) {
    updateStats(data);
});

// Helper function to update stats with animation
function updateStats(data) {
    // Update occupancy rate
    updateStatValue('occupancy-rate', data.occupancy_rate + '%');
    updateStatValue('occupancy-change', data.occupancy_change + '% increase from last week');

    // Update revenue
    updateStatValue('revenue', 'LKR' + parseFloat(data.revenue).toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));
    updateStatValue('revenue-change', data.revenue_change + '% increase from yesterday');

    // Update room counts
    updateStatValue('total-rooms', data.total_rooms);
    updateStatValue('occupied-rooms', data.occupied_rooms);
}

function updateStatValue(elementId, newValue) {
    const element = document.getElementById(elementId);
    if (element) {
        element.classList.add('updating');
        element.textContent = newValue;
        setTimeout(() => {
            element.classList.remove('updating');
        }, 300);
    }
}

// Handle date range selection
document.querySelectorAll('.dropdown-item[data-range]').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const range = this.dataset.range;
        const btn = document.querySelector('.date-range-btn');
        btn.textContent = this.textContent;

        // Update charts based on selected date range
        updateCharts(range);
    });
});

// Initialize charts
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Occupancy Chart
    const occupancyCtx = document.getElementById('occupancyChart').getContext('2d');
    new Chart(occupancyCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Occupancy Rate',
                data: [65, 70, 75, 80, 85, 90, 88],
                borderColor: '#4e73df',
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });

    // Room Type Chart
    const roomTypeCtx = document.getElementById('roomTypeChart').getContext('2d');
    new Chart(roomTypeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Standard', 'Deluxe', 'Suite', 'Executive'],
            datasets: [{
                data: [30, 25, 20, 15],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            cutout: '70%'
        }
    });
}

function updateCharts(range) {
    // Implement chart update logic based on date range
    console.log('Updating charts for range:', range);
    // This would typically involve an AJAX call to get new data
    // and then updating the charts with the new data
}
