@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Payment Details</h4>
                        <div>
                            <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="30%">Payment ID:</th>
                                        <td>#{{ $payment->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice:</th>
                                        <td>
                                            <a href="{{ route('invoices.show', $payment->invoice) }}">
                                                #{{ $payment->invoice->invoice_number }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Customer:</th>
                                        <td>
                                            <a href="{{ route('customers.show', $payment->invoice->customer) }}">
                                                {{ $payment->invoice->customer->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Amount:</th>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Date:</th>
                                        <td>{{ $payment->payment_date->format('F d, Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="30%">Payment Method:</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Transaction ID:</th>
                                        <td>{{ $payment->transaction_id ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : ($payment->status === 'failed' ? 'danger' : 'info')) }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td>{{ $payment->created_at->format('F d, Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At:</th>
                                        <td>{{ $payment->updated_at->format('F d, Y h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($payment->notes)
                    <div class="mt-4">
                        <h5>Notes</h5>
                        <div class="card">
                            <div class="card-body">
                                {{ $payment->notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($payment->status === 'completed')
                    <div class="mt-4">
                        <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf"></i> Download Receipt
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            @if($payment->invoice->payments->count() > 1)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Other Payments for Invoice #{{ $payment->invoice->invoice_number }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Payment ID</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment->invoice->payments->where('id', '!=', $payment->id) as $otherPayment)
                                <tr>
                                    <td>
                                        <a href="{{ route('payments.show', $otherPayment) }}">
                                            #{{ $otherPayment->id }}
                                        </a>
                                    </td>
                                    <td>{{ $otherPayment->payment_date->format('M d, Y') }}</td>
                                    <td>${{ number_format($otherPayment->amount, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $otherPayment->payment_method)) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $otherPayment->status === 'completed' ? 'success' : ($otherPayment->status === 'pending' ? 'warning' : ($otherPayment->status === 'failed' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($otherPayment->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
