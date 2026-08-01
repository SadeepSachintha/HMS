@extends('layouts.app')



@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center">

                        <h4 class="mb-0">Invoice #{{ $invoice->invoice_number }}</h4>

                        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-warning btn-sm" style="background-color: #D4AF37; border-color: #D4AF37; color: #111827; font-weight: 600;">
                            <i class="fas fa-file-pdf me-1"></i>
                            @if(strtolower($invoice->status) === 'paid')
                                Download Receipt
                            @else
                                Download Invoice
                            @endif
                        </a>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row mb-4">

                        <div class="col-md-6">

                            <h5>Customer Information</h5>

                            <p>

                                <strong>{{ $invoice->customer->name }}</strong><br>

                                {{ $invoice->customer->email }}<br>

                                {{ $invoice->customer->phone }}<br>

                                {{ $invoice->customer->address }}

                            </p>

                        </div>

                        <div class="col-md-6 text-md-end">

                            <h5>Invoice Details</h5>

                            <p>

                                <strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('F d, Y') }}<br>

                                <strong>Due Date:</strong> {{ $invoice->due_date->format('F d, Y') }}<br>

                                <strong>Status:</strong>

                                <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : ($invoice->status === 'sent' ? 'primary' : 'secondary')) }}">

                                    {{ ucfirst($invoice->status) }}

                                </span>

                            </p>

                        </div>

                    </div>



                    @if($invoice->event)

                    <div class="mb-4">

                        <h5>Event Details</h5>

                        <p>

                            <strong>Event:</strong>

                            <a href="{{ route('events.show', $invoice->event) }}">

                                {{ $invoice->event->name }}

                            </a><br>

                            <strong>Date:</strong> {{ $invoice->event->start_time->format('F d, Y') }}<br>

                            <strong>Location:</strong> {{ $invoice->event->location }}

                        </p>

                    </div>

                    @endif



                    <div class="table-responsive mb-4">

                        <table class="table table-striped">

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

                                    <td class="text-end">LKR{{ number_format($invoice->base_amount > 0 ? $invoice->base_amount : $invoice->subtotal, 2) }}</td>

                                </tr>

                                @if($invoice->base_amount > 0)

                                <tr>

                                    <td colspan="3" class="text-end">Service Charge:</td>

                                    <td class="text-end">LKR{{ number_format($invoice->service_charge, 2) }}</td>

                                </tr>

                                <tr>

                                    <td colspan="3" class="text-end">SSCL:</td>

                                    <td class="text-end">LKR{{ number_format($invoice->sscl_amount, 2) }}</td>

                                </tr>

                                <tr>

                                    <td colspan="3" class="text-end">TDL:</td>

                                    <td class="text-end">LKR{{ number_format($invoice->tdl_amount, 2) }}</td>

                                </tr>

                                <tr>

                                    <td colspan="3" class="text-end">VAT:</td>

                                    <td class="text-end">LKR{{ number_format($invoice->vat_amount, 2) }}</td>

                                </tr>

                                @else

                                <tr>

                                    <td colspan="3" class="text-end">Tax ({{ $invoice->tax_rate }}%):</td>

                                    <td class="text-end">LKR{{ number_format($invoice->tax_amount, 2) }}</td>

                                </tr>

                                @endif

                                <tr>

                                    <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>

                                    <td class="text-end"><strong class="text-gold">LKR{{ number_format($invoice->grand_total > 0 ? $invoice->grand_total : $invoice->total_amount, 2) }}</strong></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>



                    @if($invoice->notes)

                    <div class="mb-4">

                        <h5>Notes</h5>

                        <div class="card">

                            <div class="card-body">

                                {{ $invoice->notes }}

                            </div>

                        </div>

                    </div>

                    @endif



                    @if($invoice->payments->count() > 0)

                    <div class="mb-4">

                        <h5>Payment History</h5>

                        <div class="table-responsive">

                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Payment ID</th>

                                        <th>Date</th>

                                        <th>Method</th>

                                        <th>Amount</th>

                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($invoice->payments as $payment)

                                    <tr>

                                        <td>

                                            <a href="{{ route('payments.show', $payment) }}">

                                                #{{ $payment->id }}

                                            </a>

                                        </td>

                                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>

                                        <td>{{ $payment->payment_method === 'check' ? 'Cheque' : ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>

                                        <td>LKR{{ number_format($payment->amount, 2) }}</td>

                                        <td>

                                            <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : ($payment->status === 'failed' ? 'danger' : 'info')) }}">

                                                {{ ucfirst($payment->status) }}

                                            </span>

                                        </td>

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

                    </div>

                    @endif

                    @if(strtolower($invoice->status) !== 'paid' && strtolower($invoice->status) !== 'cancelled')
                    <div class="mt-4">

                         <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success">

                             <i class="fas fa-plus"></i> Record Payment

                         </a>

                    </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

