@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Record New Payment</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf

                        <div class="mb-3" id="invoice-summary-container" style="display: none;">
                            <label class="form-label">Invoice Details</label>
                            <div class="border rounded p-3 bg-light">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Invoice #:</strong> <span id="summary-invoice-number"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Customer:</strong> <span id="summary-customer-name"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Amount:</strong> <span id="summary-invoice-amount"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!empty($selectedInvoiceId))
                            @php
                                $selectedInvoice = $invoices->firstWhere('id', $selectedInvoiceId);
                            @endphp
                            <div class="mb-3">
                                <label class="form-label">Invoice</label>
                                <div class="form-control bg-light">
                                    #{{ $selectedInvoice->invoice_number }} - {{ $selectedInvoice->customer->name }} (LKR{{ number_format($selectedInvoice->total_amount, 2) }})
                                </div>
                                <input type="hidden" name="invoice_id" value="{{ $selectedInvoice->id }}">
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="invoice_id" class="form-label">Invoice</label>
                                <select class="form-select @error('invoice_id') is-invalid @enderror" id="invoice_id" name="invoice_id" required>
                                    <option value="">Select Invoice</option>
                                    @foreach($invoices as $invoice)
                                        <option value="{{ $invoice->id }}" {{ (old('invoice_id', $selectedInvoiceId ?? '') == $invoice->id) ? 'selected' : '' }}>
                                            #{{ $invoice->invoice_number }} - {{ $invoice->customer->name }} (LKR{{ number_format($invoice->total_amount, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('invoice_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <input type="hidden" id="reservation_id" name="reservation_id" value="{{ old('reservation_id') }}">

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">LKR</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" min="0.01" step="0.01" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="debit_card" {{ old('payment_method') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">Transaction ID</label>
                            <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}">
                            <div class="form-text">Optional: Enter the transaction ID from your payment processor</div>
                            @error('transaction_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Record Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var invoices = @json($invoices);
    function updateInvoiceSummary(invoiceId) {
        var invoice = invoices.find(inv => inv.id == invoiceId);
        if (invoice) {
            $('#summary-invoice-number').text('#' + invoice.invoice_number);
            $('#summary-customer-name').text(invoice.customer.name);
            $('#summary-invoice-amount').text('LKR' + Number(invoice.total_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#invoice-summary-container').show();
        } else {
            $('#invoice-summary-container').hide();
        }
    }
    // On page load, show summary if pre-selected
    var initialInvoiceId = $('#invoice_id').val();
    updateInvoiceSummary(initialInvoiceId);
    // On change
    $('#invoice_id').change(function() {
        updateInvoiceSummary($(this).val());
        var selectedOption = $(this).find('option:selected');
        if (selectedOption.val()) {
            var match = selectedOption.text().match(/LKR([0-9,]+(\.[0-9]{2})?)/);
            if (match) {
                var amount = match[1];
                $('#amount').val(amount.replace(/,/g, ''));
            }
        }
        var invoiceId = $(this).val();
        var reservationId = null;
        invoices.forEach(function(invoice) {
            if (invoiceId == invoice.id) {
                reservationId = invoice.reservation_id;
            }
        });
        if (reservationId) {
            $('#reservation_id').val(reservationId);
        } else {
            $('#reservation_id').val('');
        }
    });
});
</script>
@endsection
