@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Create New Invoice</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('invoices.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id"
                                    name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Select Event or Reservation</label>
                                <select class="form-select" id="invoice-context-source" name="invoice_context_source"
                                    required>
                                    <option value="">-- Select Event or Reservation --</option>
                                    <optgroup label="Events">
                                        @foreach ($events as $event)
                                            <option value="event-{{ $event->id }}"
                                                data-description="Event: {{ $event->name }}"
                                                data-unit-price="{{ $event->price ?? 0 }}">
                                                Event: {{ $event->name }}
                                                ({{ $event->start_time ? $event->start_time->format('M d, Y') : '' }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Reservations">
                                        @foreach ($reservations as $reservation)
                                            @php
                                                $nights = 0;
                                                if ($reservation->check_in_date && $reservation->check_out_date) {
                                                    $nights = $reservation->check_out_date->diffInDays($reservation->check_in_date);
                                                }
                                                $pricePerNight = $reservation->room && $reservation->room->roomType ? $reservation->room->roomType->price_per_night : 0;
                                                $totalPrice = $nights * $pricePerNight;
                                            @endphp
                                            <option value="reservation-{{ $reservation->id }}"
                                                data-unit-price="{{ $pricePerNight }}"
                                                data-quantity="{{ $nights }}"
                                                data-reservation-id="{{ $reservation->id }}"
                                                {{ old('reservation_id') == $reservation->id ? 'selected' : '' }}>
                                                #{{ $reservation->id }} - {{ $reservation->customer->name }} (Room:
                                                {{ $reservation->room_id }}) - {{ $nights }} nights - LKR {{ number_format($totalPrice, 2) }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="invoice_date" class="form-label">Invoice Date</label>
                                <input type="date" class="form-control @error('invoice_date') is-invalid @enderror"
                                    id="invoice_date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}"
                                    required>
                                @error('invoice_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                    id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Invoice Items</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Fixed Event/Reservation Charge Row -->
                                    <div id="main-charge-row" class="mb-3" style="display: none;">
                                        <div class="row align-items-end">
                                            <div class="col-md-4">
                                                <label class="form-label">Description</label>
                                                <input type="text" class="form-control main-charge-description" name="main_charge[description]" value="" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity</label>
                                                <input type="number" class="form-control main-charge-quantity" name="main_charge[quantity]" value="1" min="1" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Unit Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">LKR</span>
                                                    <input type="number" class="form-control main-charge-unit-price" name="main_charge[unit_price]" value="0.00" min="0" step="0.01" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">LKR</span>
                                                    <input type="text" class="form-control main-charge-total" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6>Food Items</h6>
                                    <div id="invoice-items">
                                        <div class="invoice-item mb-3">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Food Item</label>
                                                    <select class="form-select item-source" name="items[0][food_item_id]">
                                                        <option value="">Select Food Item</option>
                                                        @foreach($foodItems as $foodItem)
                                                            <option value="{{ $foodItem->id }}" data-description="{{ $foodItem->name }}" data-unit-price="{{ $foodItem->price }}">{{ $foodItem->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Quantity</label>
                                                    <input type="number" class="form-control quantity" name="items[0][quantity]" value="1" min="1" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Unit Price</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">LKR</span>
                                                        <input type="number" class="form-control unit-price" name="items[0][unit_price]" value="0.00" min="0" step="0.01" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Total</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">LKR</span>
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
                                        <input type="number" class="form-control @error('tax_rate') is-invalid @enderror"
                                            id="tax_rate" name="tax_rate" value="{{ old('tax_rate', 0) }}" min="0"
                                            max="100" step="0.01">
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
                                                <span id="subtotal">LKR0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Tax:</span>
                                                <span id="tax">LKR0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <strong>Total:</strong>
                                                <strong id="total">LKR0.00</strong>
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
                            <input type="hidden" name="reservation_id" id="reservation_id" value="{{ old('reservation_id') }}">
                            <input type="hidden" name="event_id" id="event_id" value="{{ old('event_id') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let itemCount = 1;

            // Show and fill main charge row when event/reservation is selected
            $('#invoice-context-source').on('change', function() {
                var selected = $(this).find('option:selected');
                var unitPrice = selected.data('unit-price');
                var quantity = selected.data('quantity') || 1;
                var reservationId = selected.data('reservation-id');
                var description = selected.text();
                if (unitPrice !== undefined && description) {
                    $('#main-charge-row').show();
                    $('.main-charge-description').val(description.trim());
                    $('.main-charge-quantity').val(quantity);
                    $('.main-charge-unit-price').val(unitPrice);
                    var total = (parseFloat(unitPrice) || 0) * (parseInt(quantity) || 1);
                    $('.main-charge-total').val(total.toFixed(2));
                } else {
                    $('#main-charge-row').hide();
                    $('.main-charge-description').val('');
                    $('.main-charge-quantity').val('1');
                    $('.main-charge-unit-price').val('0.00');
                    $('.main-charge-total').val('0.00');
                }
                updateTotals();
            });

            function bindItemSourceDropdown(item) {
                item.find('.item-source').on('change', function() {
                    var selected = $(this).find('option:selected');
                    var unitPrice = selected.data('unit-price');
                    var description = selected.data('description');
                    if (unitPrice !== undefined) {
                        item.find('.unit-price').val(unitPrice).trigger('input');
                    }
                });
            }

            // Bind for the first row
            bindItemSourceDropdown($('.invoice-item').first());

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
                newItem.find('.item-source').val('');

                // Update input names
                newItem.find('input, select').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace('[0]', `[${itemCount}]`));
                    }
                });

                $('#invoice-items').append(newItem);
                // Trigger calculation for the new row
                newItem.find('.quantity, .unit-price').trigger('input');
                bindItemSourceDropdown(newItem);
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
                // Add main charge if visible
                if ($('#main-charge-row').is(':visible')) {
                    subtotal += parseFloat($('.main-charge-total').val()) || 0;
                }
                $('.item-total').each(function() {
                    subtotal += parseFloat($(this).val()) || 0;
                });

                const taxRate = parseFloat($('#tax_rate').val()) || 0;
                const taxAmount = subtotal * (taxRate / 100);
                const total = subtotal + taxAmount;

                $('#subtotal').text('LKR' + subtotal.toFixed(2));
                $('#tax').text('LKR' + taxAmount.toFixed(2));
                $('#total').text('LKR' + total.toFixed(2));

                $('#subtotal-input').val(subtotal.toFixed(2));
                $('#tax-amount-input').val(taxAmount.toFixed(2));
                $('#total-amount-input').val(total.toFixed(2));
            }

            // Update totals when tax rate changes
            $('#tax_rate').on('input', updateTotals);

            // Initialize totals and calculate for all rows on page load
            $('.invoice-item').each(function() {
                const item = $(this);
                const quantity = parseFloat(item.find('.quantity').val()) || 0;
                const unitPrice = parseFloat(item.find('.unit-price').val()) || 0;
                const total = quantity * unitPrice;
                item.find('.item-total').val(total.toFixed(2));
            });
            updateTotals();

            // Set reservation_id or event_id based on selection
            $('#invoice-context-source').on('change', function() {
                var selected = $(this).val();
                if (selected && selected.startsWith('reservation-')) {
                    $('#reservation_id').val(selected.replace('reservation-', ''));
                    $('#event_id').val('');
                } else if (selected && selected.startsWith('event-')) {
                    $('#event_id').val(selected.replace('event-', ''));
                    $('#reservation_id').val('');
                } else {
                    $('#reservation_id').val('');
                    $('#event_id').val('');
                }
            });
        });
    </script>
@endpush
