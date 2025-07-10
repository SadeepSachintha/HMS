<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt #{{ $payment->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 24px; background: #fff; }
        .section { margin-bottom: 28px; }
        .label { font-weight: bold; display: inline-block; min-width: 140px; }
        .status {
            display: inline-block;
            padding: 0.25em 0.7em;
            font-size: 1em;
            border-radius: 0.25rem;
            color: #fff;
        }
        .status-completed { background: #28a745; }
        .status-pending { background: #ffc107; color: #212529; }
        .status-failed { background: #dc3545; }
        .status-other { background: #17a2b8; }
        h4, h5 { margin-bottom: 10px; }
        p { margin: 0 0 8px 0; }
        hr { margin: 24px 0; border: none; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <h4>Payment Receipt #{{ $payment->id }}</h4>
    <div class="section">
        <h4>Customer Information</h4>
        <p><span class="label">Name:</span> {{ $payment->invoice->customer->name }}</p>
        <p><span class="label">Email:</span> {{ $payment->invoice->customer->email }}</p>
        <p><span class="label">Phone:</span> {{ $payment->invoice->customer->phone }}</p>
        <p><span class="label">Address:</span> {{ $payment->invoice->customer->address }}</p>
    </div>
    <hr>
    <div class="section">
        <h4>Payment Details</h4>
        <p><span class="label">Payment Date:</span> {{ $payment->payment_date->format('F d, Y') }}</p>
        <p><span class="label">Status:</span>
            <span class="status status-{{ $payment->status === 'completed' ? 'completed' : ($payment->status === 'pending' ? 'pending' : ($payment->status === 'failed' ? 'failed' : 'other')) }}">
                {{ ucfirst($payment->status) }}
            </span>
        </p>
        <p><span class="label">Payment ID:</span> #{{ $payment->id }}</p>
        <p><span class="label">Invoice:</span> #{{ $payment->invoice->invoice_number }}</p>
        <p><span class="label">Amount:</span> ${{ number_format($payment->amount, 2) }}</p>
        <p><span class="label">Payment Method:</span> {{ $payment->payment_method === 'check' ? 'Cheque' : ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
        <p><span class="label">Transaction ID:</span> {{ $payment->transaction_id ?? 'Not provided' }}</p>
        <p><span class="label">Notes:</span> {{ $payment->notes ?? '-' }}</p>
    </div>
    <hr>
    <div class="section">
        <p><strong>Thank you for your payment!</strong></p>
    </div>
</body>
</html>
