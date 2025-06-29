@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create New Invoice</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="event_id" class="form-label">Event</label>
                            <select class="form-select @error('event_id') is-invalid @enderror" id="event_id" name="event_id">
                                <option value="">Select Event (Optional)</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                        {{ $event->name }} ({{ $event->start_time->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="invoice_date" class="form-label">Invoice Date</label>
                            <input type="date" class="form-control @error('invoice_date') is-invalid @enderror" id="invoice_date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                            @error('invoice_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Invoice Items</h5>
                            </div>
                            <div class="card-body">
                                <div id="invoice-items">
                                    <div class="invoice-item mb-3">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label">Description</label>
                                                <input type="text" class="form-control" name="items[0][description]" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity</label>
                                                <input type="number" class="form-control quantity" name="items[0][quantity]" value="1" min="1" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Unit Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control unit-price" name="items[0][unit_price]" value="0.00" min="0" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" class="form-control item-total" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label d-block">&nbsp;</label>
                                                <button type="button" class="btn btn-danger remove-item" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-success" id="add-item">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                    <input type="number" class="form-control @error('tax_rate') is-invalid @enderror" id="tax_rate" name="tax_rate" value="{{ old('tax_rate', 0) }}" min="0" max="100" step="0.01">
                                    @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span id="subtotal">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax:</span>
                                            <span id="tax">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <strong>Total:</strong>
                                            <strong id="total">$0.00</strong>
                                        </div>
                                        <input type="hidden" name="subtotal" id="subtotal-input">
                                        <input type="hidden" name="tax_amount" id="tax-amount-input">
                                        <input type="hidden" name="total_amount" id="total-amount-input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Invoice</button>
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
    let itemCount = 1;

    // Set minimum due date based on invoice date
    $('#invoice_date').change(function() {
        $('#due_date').attr('min', $(this).val());
    });

    // Add new item
    $('#add-item').click(function() {
        const newItem = $('.invoice-item').first().clone();
        newItem.find('input').val('');
        newItem.find('.quantity').val(1);
        newItem.find('.unit-price').val('0.00');
        newItem.find('.item-total').val('');
        newItem.find('.remove-item').prop('disabled', false);

        // Update input names
        newItem.find('input').each(function() {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace('[0]', `[${itemCount}]`));
            }
        });

        $('#invoice-items').append(newItem);
        itemCount++;
        updateTotals();
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        $(this).closest('.invoice-item').remove();
        updateTotals();
    });

    // Calculate item total
    $(document).on('input', '.quantity, .unit-price', function() {
        const item = $(this).closest('.invoice-item');
        const quantity = parseFloat(item.find('.quantity').val()) || 0;
        const unitPrice = parseFloat(item.find('.unit-price').val()) || 0;
        const total = quantity * unitPrice;
        item.find('.item-total').val(total.toFixed(2));
        updateTotals();
    });

    // Update totals
    function updateTotals() {
        let subtotal = 0;
        $('.item-total').each(function() {
            subtotal += parseFloat($(this).val()) || 0;
        });

        const taxRate = parseFloat($('#tax_rate').val()) || 0;
        const taxAmount = subtotal * (taxRate / 100);
        const total = subtotal + taxAmount;

        $('#subtotal').text('$' + subtotal.toFixed(2));
        $('#tax').text('$' + taxAmount.toFixed(2));
        $('#total').text('$' + total.toFixed(2));

        $('#subtotal-input').val(subtotal.toFixed(2));
        $('#tax-amount-input').val(taxAmount.toFixed(2));
        $('#total-amount-input').val(total.toFixed(2));
    }

    // Update totals when tax rate changes
    $('#tax_rate').on('input', updateTotals);

    // Initialize totals
    updateTotals();
});
</script>
@endsection
