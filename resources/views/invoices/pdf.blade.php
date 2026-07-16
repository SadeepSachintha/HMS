<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 20px; }
        h4, h5 { margin-bottom: 8px; }
        .section { margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 0.25em 0.6em; font-size: 0.9em; border-radius: 0.25rem; color: #fff; }
        .bg-success { background: #28a745; }
        .bg-danger { background: #dc3545; }
        .bg-primary { background: #007bff; }
        .bg-secondary { background: #6c757d; }
        .bg-warning { background: #ffc107; color: #212529; }
        .bg-info { background: #17a2b8; }
        .card { border: 1px solid #eee; border-radius: 4px; margin-bottom: 12px; }
        .card-body { padding: 10px; }
    </style>
</head>
<body>
    <h4>Invoice #{{ $invoice->invoice_number }}</h4>
    <div class="section">
        <div style="width: 48%; float: left;">
            <h4>Customer Information</h4>
            <p>
                <strong>{{ $invoice->customer->name }}</strong><br>
                {{ $invoice->customer->email }}<br>
                {{ $invoice->customer->phone }}<br>
                {{ $invoice->customer->address }}
            </p>
        </div>
        <div style="width: 48%; float: right; text-align: right;">
            <h4>Invoice Details</h4>
            <p>
                <strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('F d, Y') }}<br>
                <strong>Due Date:</strong> {{ $invoice->due_date->format('F d, Y') }}<br>
            </p>
        </div>
        <div style="clear: both;"></div>
    </div>

    @if($invoice->event)
    <div class="section">
        <h4>Event Details</h4>
        <p>
            <strong>Event:</strong> {{ $invoice->event->name }}<br>
            <strong>Date:</strong> {{ $invoice->event->start_time->format('F d, Y') }}<br>
            <strong>Location:</strong> {{ $invoice->event->location }}
        </p>
    </div>
    @endif

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Unit Price</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">LKR{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-end">LKR{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end">Subtotal:</td>
                    <td class="text-end">LKR{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">Tax ({{ $invoice->tax_rate }}%):</td>
                    <td class="text-end">LKR{{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td class="text-end"><strong>LKR{{ number_format($invoice->total_amount, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($invoice->notes)
    <div class="section">
        <h5>Notes</h5>
        <div class="card">
            <div class="card-body">
                {{ $invoice->notes }}
            </div>
        </div>
    </div>
    @endif

    @if($invoice->payments->count() > 0)
    <div class="section">
        <h5>Payment History</h5>
        <table>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->payments as $payment)
                <tr>
                    <td>#{{ $payment->id }}</td>
                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                    <td>{{ $payment->payment_method === 'check' ? 'Cheque' : ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    <td>LKR{{ number_format($payment->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total Paid:</strong></td>
                    <td colspan="2"><strong>LKR{{ number_format($invoice->payments->where('status', 'completed')->sum('amount'), 2) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Balance Due:</strong></td>
                    <td colspan="2"><strong>LKR{{ number_format($invoice->total_amount - $invoice->payments->where('status', 'completed')->sum('amount'), 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif
</body>
</html>
