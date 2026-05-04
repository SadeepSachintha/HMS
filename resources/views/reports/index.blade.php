@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar/Menu for Report Types -->
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active" id="report-occupancy">Occupancy Report</a>
                <a href="#" class="list-group-item list-group-item-action" id="report-revenue">Revenue Report</a>
                <a href="#" class="list-group-item list-group-item-action" id="report-reservations">Reservations Report</a>
            </div>
        </div>
        <!-- Main Content Area -->
        <div class="col-md-9">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" id="report-title">Occupancy Report</h6>
                </div>
                <div class="card-body">
                    <!-- Date Range Filter -->
                    <form id="report-filter-form" class="row g-3 mb-4 align-items-end">
                        <div class="col-md-4">
                            <label for="from_date" class="form-label">From</label>
                            <input type="date" class="form-control" id="from_date" name="from_date">
                        </div>
                        <div class="col-md-4">
                            <label for="to_date" class="form-label">To</label>
                            <input type="date" class="form-control" id="to_date" name="to_date">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-success mt-4" id="search-report">Search</button>
                        </div>
                    </form>
                    <!-- Placeholder for DataTable -->
                    <div id="report-table-container">
                        <!-- DataTable will be rendered here based on report type -->
                        <div class="alert alert-info">Select a report type and date range, then click Search to view the report.</div>
                    </div>

                    <!-- Download buttons (initially hidden) -->
                    <div id="download-buttons" class="mt-3" style="display: none;">
                        <button type="button" class="btn btn-success me-2" onclick="exportExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" class="btn btn-danger" onclick="exportPdf()">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            { title: 'Total amount (LKR)', data: 'total_amount' }
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
    let tableHtml = '<table id="report-table" class="table table-striped" style="width:100%"></table>';
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
    // For revenue report, add total row
    if (type === 'revenue' && data.total !== undefined) {
        $(table.table().footer()).remove();
        $('#report-table').append('<tfoot><tr><th colspan="3" style="text-align:right">Total</th><th>' + data.total + '</th></tr></tfoot>');
    }

    // Show download buttons after table is rendered
    $('#download-buttons').show();
}

$(document).ready(function() {
    // Sidebar navigation logic
    const reportTypes = ['occupancy', 'revenue', 'reservations'];
    reportTypes.forEach(type => {
        $('#report-' + type).on('click', function(e) {
            e.preventDefault();
            reportTypes.forEach(t => $('#report-' + t).removeClass('active'));
            $(this).addClass('active');
            $('#report-title').text($(this).text());
            currentReportType = type;
            $('#report-table-container').html('<div class="alert alert-info">Select a date range and click Search to view the ' + $(this).text() + '.</div>');
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
