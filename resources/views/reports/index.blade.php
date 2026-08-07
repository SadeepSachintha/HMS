@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="page-title mb-4">Reports & Analytics</h2>
    <div class="row g-4">
        <!-- Sidebar/Menu for Report Types -->
        <div class="col-xl-3 col-lg-4">
            <div class="glass-card h-100">
                <div class="card-header bg-transparent border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="section-title mb-0">Report Categories</h5>
                </div>
                <div class="card-body p-3">
                    <div class="list-group list-group-flush border-0 custom-report-list">
                        <a href="#" class="list-group-item list-group-item-action active mb-2 rounded-3 border-0 d-flex align-items-center" id="report-occupancy">
                            <i class="fas fa-bed me-3"></i> Occupancy Report
                        </a>
                        <a href="#" class="list-group-item list-group-item-action mb-2 rounded-3 border-0 d-flex align-items-center" id="report-revenue">
                            <i class="fas fa-hand-holding-usd me-3"></i> Revenue Report
                        </a>
                        <a href="#" class="list-group-item list-group-item-action mb-2 rounded-3 border-0 d-flex align-items-center" id="report-food_sales">
                            <i class="fas fa-utensils me-3"></i> F&B Sales Report
                        </a>
                        <a href="#" class="list-group-item list-group-item-action mb-2 rounded-3 border-0 d-flex align-items-center" id="report-tax_levies">
                            <i class="fas fa-file-invoice-dollar me-3"></i> Tax & Levies Audit
                        </a>
                        <a href="#" class="list-group-item list-group-item-action mb-2 rounded-3 border-0 d-flex align-items-center" id="report-reservations">
                            <i class="fas fa-calendar-check me-3"></i> Reservations Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-xl-9 col-lg-8">
            <div class="glass-card shadow-lg mb-4 h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-4 px-4">
                    <h4 class="section-title mb-0" id="report-title">Occupancy Report</h4>
                    <div id="download-buttons" class="btn-group" style="display: none;">
                        <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="exportExcel()">
                            <i class="fas fa-file-excel me-2"></i> Excel
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="exportPdf()">
                            <i class="fas fa-file-pdf me-2"></i> PDF
                        </button>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <!-- Date Range Filter -->
                    <div class="filter-section p-4 rounded-4 bg-dark-soft mb-4 border border-secondary border-opacity-10">
                        <form id="report-filter-form" class="row g-4 align-items-end">
                            <div class="col-md-5">
                                <label for="from_date" class="form-label small text-uppercase letter-spacing-1">Start Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-calendar-alt text-secondary"></i></span>
                                    <input type="date" class="form-control border-start-0" id="from_date" name="from_date">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="to_date" class="form-label small text-uppercase letter-spacing-1">End Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-calendar-day text-secondary"></i></span>
                                    <input type="date" class="form-control border-start-0" id="to_date" name="to_date">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary w-100 py-2 shadow-sm" id="search-report">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Placeholder for DataTable -->
                    <div id="report-table-container" class="table-responsive custom-scrollbar">
                        <div class="text-center py-5">
                            <div class="stat-icon-wrapper bg-soft-gold mx-auto mb-4">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <h5 class="text-muted fw-normal">Select a report type and date range to begin</h5>
                            <p class="text-muted small">Choose parameters above and click search to view insights</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-report-list .list-group-item {
        background: transparent;
        color: var(--text-muted);
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    .custom-report-list .list-group-item:hover {
        background: rgba(212, 175, 55, 0.05);
        color: var(--secondary-color);
    }
    .custom-report-list .list-group-item.active {
        background: rgba(212, 175, 55, 0.1);
        color: var(--secondary-color);
        border-left: 4px solid var(--secondary-color) !important;
        font-weight: 600;
    }
    .bg-dark-soft {
        background: rgba(0, 0, 0, 0.2);
    }
    .letter-spacing-1 {
        letter-spacing: 1px;
    }
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    #report-table thead th {
        border-top: none;
        background: rgba(212, 175, 55, 0.05) !important;
    }
</style>
@endsection

@push('scripts')
<script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/vendor/dataTables.bootstrap5.min.css') }}">
<script src="{{ asset('js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/vendor/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/vendor/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/vendor/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/vendor/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/vendor/buttons.print.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/vendor/buttons.bootstrap5.min.css') }}">
<script>
let currentReportType = 'occupancy';

function getTableColumns(type) {
    if (type === 'occupancy') {
        return [
            { title: 'Room no', data: 'room_no' },
            { title: 'Room type', data: 'room_type' },
            { title: 'Check-in date', data: 'check_in' },
            { title: 'Check-out date', data: 'check_out' },
            { title: 'Status', data: 'status' }
        ];
    } else if (type === 'revenue') {
        return [
            { title: 'Payment id', data: 'payment_id' },
            { title: 'Payment method', data: 'payment_method' },
            { title: 'Payment date', data: 'payment_date' },
            { title: 'Total amount (LKR)', data: 'total_amount', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } }
        ];
    } else if (type === 'food_sales') {
        return [
            { title: 'Food Item Name', data: 'food_item_name' },
            { title: 'Unit Price (LKR)', data: 'unit_price', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } },
            { title: 'Quantity Sold', data: 'quantity_sold' },
            { title: 'Total Sales (LKR)', data: 'total_sales', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } }
        ];
    } else if (type === 'tax_levies') {
        return [
            { title: 'Invoice Number', data: 'invoice_number' },
            { title: 'Invoice Date', data: 'invoice_date' },
            { title: 'Subtotal (LKR)', data: 'base_amount', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } },
            { title: 'Service Charge (LKR)', data: 'service_charge', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } },
            { title: 'SSCL (LKR)', data: 'sscl_amount', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } },
            { title: 'TDL (LKR)', data: 'tdl_amount', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } },
            { title: 'VAT (LKR)', data: 'vat_amount', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } },
            { title: 'Grand Total (LKR)', data: 'grand_total', render: function(d) { return parseFloat(d).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); } }
        ];
    } else {
        return [
            { title: 'Customer', data: 'customer' },
            { title: 'Reservation date', data: 'reservation_date' },
            { title: 'Check-in', data: 'check_in' },
            { title: 'Check-out', data: 'check_out' },
            { title: 'Status', data: 'status' }
        ];
    }
}

function renderTable(type, data) {
    let columns = getTableColumns(type);
    let tableHtml = '<table id="report-table" class="table table-striped table-hover" style="width:100%"></table>';
    $('#report-table-container').html(tableHtml);
    let dtOptions = {
        data: Array.isArray(data) ? data : (data.rows || []),
        columns: columns,
        dom: 'rtip',
        destroy: true,
        searching: true,
        paging: true
    };
    let table = $('#report-table').DataTable(dtOptions);
    if (type === 'revenue' && data.total !== undefined) {
        $(table.table().footer()).remove();
        $('#report-table').append('<tfoot><tr><th colspan="3" style="text-align:right">Total</th><th>LKR ' + parseFloat(data.total).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th></tr></tfoot>');
    } else if (type === 'food_sales' && data.total !== undefined) {
        $(table.table().footer()).remove();
        $('#report-table').append('<tfoot><tr><th colspan="3" style="text-align:right">Total</th><th>LKR ' + parseFloat(data.total).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th></tr></tfoot>');
    } else if (type === 'tax_levies' && data.totals !== undefined) {
        $(table.table().footer()).remove();
        let t = data.totals;
        let footerHtml = '<tfoot><tr>' +
            '<th colspan="2" style="text-align:right">Total</th>' +
            '<th>LKR ' + parseFloat(t.base_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th>' +
            '<th>LKR ' + parseFloat(t.service_charge).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th>' +
            '<th>LKR ' + parseFloat(t.sscl_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th>' +
            '<th>LKR ' + parseFloat(t.tdl_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th>' +
            '<th>LKR ' + parseFloat(t.vat_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th>' +
            '<th>LKR ' + parseFloat(t.grand_total).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</th>' +
            '</tr></tfoot>';
        $('#report-table').append(footerHtml);
    }

    // Show download buttons after table is rendered
    $('#download-buttons').fadeIn();
}

$(document).ready(function() {
    // Sidebar navigation logic
    const reportTypes = ['occupancy', 'revenue', 'food_sales', 'tax_levies', 'reservations'];
    reportTypes.forEach(type => {
        $('#report-' + type).on('click', function(e) {
            e.preventDefault();
            reportTypes.forEach(t => $('#report-' + t).removeClass('active'));
            $(this).addClass('active');
            $('#report-title').text($(this).text().trim());
            currentReportType = type;
            $('#report-table-container').html(`
                <div class="text-center py-5">
                    <div class="stat-icon-wrapper bg-soft-gold mx-auto mb-4">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <h5 class="text-muted fw-normal">Select a date range to begin the ${$(this).text().trim()}</h5>
                    <p class="text-muted small">Choose parameters above and click search to view insights</p>
                </div>
            `);
        });
    });

    // Search button logic
    $('#search-report').on('click', function() {
        let from = $('#from_date').val();
        let to = $('#to_date').val();
        if (!from || !to) {
            $('#report-table-container').html('<div class="alert alert-danger">Please select both From and To dates.</div>');
            return;
        }
        $.ajax({
            url: '{{ url('reports/fetch-data') }}',
            method: 'POST',
            data: {
                report_type: currentReportType,
                from_date: from,
                to_date: to,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#report-table-container').html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5 class="text-muted">Generating Report...</h5>
                    </div>
                `);
            },
            success: function(response) {
                if (response.success) {
                    renderTable(currentReportType, response.data);
                } else {
                    $('#report-table-container').html('<div class="alert alert-danger">Failed to load report data.</div>');
                }
            },
            error: function(xhr) {
                $('#report-table-container').html('<div class="alert alert-danger">Error loading report data.</div>');
            }
        });
    });
});

// Move these outside the document ready block so they are global
function exportExcel() {
    let from = $('#from_date').val();
    let to = $('#to_date').val();
    if (!from || !to) {
        alert('Please select both From and To dates.');
        return;
    }
    // Create a form and submit it
    let form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("reports.export-excel") }}';
    let reportType = document.createElement('input');
    reportType.type = 'hidden';
    reportType.name = 'report_type';
    reportType.value = currentReportType;
    form.appendChild(reportType);
    let fromDate = document.createElement('input');
    fromDate.type = 'hidden';
    fromDate.name = 'from_date';
    fromDate.value = from;
    form.appendChild(fromDate);
    let toDate = document.createElement('input');
    toDate.type = 'hidden';
    toDate.name = 'to_date';
    toDate.value = to;
    form.appendChild(toDate);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function exportPdf() {
    let from = $('#from_date').val();
    let to = $('#to_date').val();
    if (!from || !to) {
        alert('Please select both From and To dates.');
        return;
    }
    // Create a form and submit it
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("reports.export-pdf") }}';
    let csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    let reportType = document.createElement('input');
    reportType.type = 'hidden';
    reportType.name = 'report_type';
    reportType.value = currentReportType;
    form.appendChild(reportType);
    let fromDate = document.createElement('input');
    fromDate.type = 'hidden';
    fromDate.name = 'from_date';
    fromDate.value = from;
    form.appendChild(fromDate);
    let toDate = document.createElement('input');
    toDate.type = 'hidden';
    toDate.name = 'to_date';
    toDate.value = to;
    form.appendChild(toDate);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endpush
