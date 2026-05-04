// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    initRevenueChart();
    initInventoryChart();
});

let revenueChart, inventoryChart;

function initRevenueChart() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const data = dashboardData.revenueChart;
    
    revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.month),
            datasets: [{
                label: 'Revenue',
                data: data.map(item => item.amount),
                backgroundColor: 'rgba(212, 175, 55, 0.6)',
                borderColor: '#D4AF37',
                borderWidth: 1,
                borderRadius: 8,
                hoverBackgroundColor: '#D4AF37'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0A1128',
                    titleColor: '#D4AF37',
                    bodyColor: '#fff',
                    borderColor: 'rgba(212, 175, 55, 0.2)',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'LKR ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { 
                        color: '#b0b5c1',
                        callback: function(value) {
                            if (value >= 1000) return 'LKR ' + (value / 1000) + 'k';
                            return 'LKR ' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#b0b5c1' }
                }
            }
        }
    });
}

function initInventoryChart() {
    const ctx = document.getElementById('inventoryChart').getContext('2d');
    const status = dashboardData.roomStatus;
    
    inventoryChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Occupied', 'Maintenance', 'Dirty'],
            datasets: [{
                data: [status.available, status.occupied, status.maintenance, status.dirty],
                backgroundColor: [
                    '#28a745', // Green
                    '#007bff', // Blue
                    '#ffc107', // Yellow
                    '#dc3545'  // Red
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0A1128',
                    padding: 12,
                    displayColors: true
                }
            }
        }
    });
}

// Real-time updates via Pusher (if available)
if (window.pusherKey) {
    const pusher = new Pusher(window.pusherKey, {
        cluster: window.pusherCluster,
        encrypted: true
    });

    const channel = pusher.subscribe('dashboard-stats');
    channel.bind('App\\Events\\DashboardStatsEvent', function(data) {
        updateDashboardUI(data);
    });
}

function updateDashboardUI(data) {
    // Update individual stats
    animateValue('occupancy-rate', data.occupancy_rate + '%');
    animateValue('available-rooms', data.room_status.available);
    animateValue('total-rooms', data.total_rooms);
    animateValue('revenue', 'LKR' + parseFloat(data.revenue).toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));

    // Update charts
    if (revenueChart) {
        revenueChart.data.datasets[0].data = data.revenue_chart.map(item => item.amount);
        revenueChart.update();
    }
    
    if (inventoryChart) {
        inventoryChart.data.datasets[0].data = [
            data.room_status.available,
            data.room_status.occupied,
            data.room_status.maintenance,
            data.room_status.dirty
        ];
        inventoryChart.update();
    }
}

function animateValue(id, newValue) {
    const el = document.getElementById(id);
    if (!el) return;
    
    el.classList.add('updating');
    setTimeout(() => {
        el.textContent = newValue;
        el.classList.remove('updating');
    }, 150);
}
