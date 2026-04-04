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
                                    <div class="col-md-4">
                                        <strong>Balance:</strong> <span id="summary-invoice-balance"></span>
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
                                <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $selectedInvoice->id }}">
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
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <label for="paid_amount" class="form-label mt-2">Paid Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">LKR</span>
                                <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount" name="paid_amount" value="{{ old('paid_amount') }}" min="0.01" step="0.01" required>
                            </div>
                            @error('paid_amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <label for="balance" class="form-label mt-2">Balance Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">LKR</span>
                                <input type="number" class="form-control @error('balance') is-invalid @enderror" id="balance" name="balance" value="{{ old('balance') }}" min="0" step="0.01" required readonly>
                            </div>
                            <div class="form-text">Calculated as Amount − Paid amount.</div>
                            @error('balance')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
    var hasOldAmount = @json(old('amount') !== null && old('amount') !== '');
    var hasOldPaid = @json(old('paid_amount') !== null && old('paid_amount') !== '');

    function getInvoice(invoiceId) {
        if (!invoiceId) return null;
        return invoices.find(function(inv) { return String(inv.id) === String(invoiceId); });
    }

    function updateInvoiceSummary(invoiceId) {
        var invoice = getInvoice(invoiceId);
        if (invoice) {
            $('#summary-invoice-number').text('#' + invoice.invoice_number);
            $('#summary-customer-name').text(invoice.customer.name);
            var total = Number(invoice.total_amount);
            var formatted = 'LKR' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $('#summary-invoice-amount').text(formatted);
            $('#summary-invoice-balance').text(formatted);
            $('#invoice-summary-container').show();
        } else {
            $('#invoice-summary-container').hide();
        }
    }

    function fillAmountFromInvoice(invoiceId) {
        var invoice = getInvoice(invoiceId);
        if (!invoice) return;
        $('#amount').val(Number(invoice.total_amount).toFixed(2));
    }

    function syncReservationHidden(invoiceId) {
        var invoice = getInvoice(invoiceId);
        if (invoice && invoice.reservation_id) {
            $('#reservation_id').val(invoice.reservation_id);
        } else {
            $('#reservation_id').val('');
        }
    }

    function recalculateBalance() {
        var amt = parseFloat($('#amount').val());
        var paidRaw = $('#paid_amount').val();
        var paid = (paidRaw === '' || paidRaw === null) ? 0 : parseFloat(paidRaw);
        if (isNaN(amt)) {
            $('#balance').val('');
            return;
        }
        if (isNaN(paid)) {
            paid = 0;
        }
        var bal = Math.max(0, amt - paid);
        $('#balance').val(bal.toFixed(2));
    }

    $('#invoice_id').on('change', function() {
        var invoiceId = $(this).val();
        updateInvoiceSummary(invoiceId);
        fillAmountFromInvoice(invoiceId);
        syncReservationHidden(invoiceId);
        recalculateBalance();
    });

    $('#amount, #paid_amount').on('input change', function() {
        recalculateBalance();
    });

    var initialInvoiceId = $('#invoice_id').val();
    if (initialInvoiceId) {
        updateInvoiceSummary(initialInvoiceId);
        if (!hasOldAmount) {
            fillAmountFromInvoice(initialInvoiceId);
        }
        syncReservationHidden(initialInvoiceId);
    }

    if (hasOldPaid || $('#paid_amount').val()) {
        recalculateBalance();
    }
});
</script>
@endsection
