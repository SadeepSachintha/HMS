@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Invoice #{{ $invoice->invoice_number }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.update-status-notes', $invoice) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <div class="form-control" readonly tabindex="-1">
                                {{ $invoice->customer->name }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="event_id" class="form-label">Event</label>
                            <div class="form-control" readonly tabindex="-1">
                                @if($invoice->event)
                                    {{ $invoice->event->name }} ({{ $invoice->event->start_time->format('M d, Y') }})
                                @else
                                    No event associated
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="invoice_date" class="form-label">Invoice Date</label>
                            <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="{{ $invoice->invoice_date->format('Y-m-d') }}" readonly tabindex="-1">
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $invoice->due_date->format('Y-m-d') }}" readonly tabindex="-1">
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Invoice Items</h5>
                            </div>
                            <div class="card-body">
                                <div id="invoice-items">
                                    @foreach($invoice->items as $index => $item)
                                    <div class="invoice-item mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Description</label>
                                                <input type="text" class="form-control" value="{{ $item->description }}" readonly tabindex="-1">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity</label>
                                                <input type="number" class="form-control" value="{{ $item->quantity }}" readonly tabindex="-1">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Unit Price (LKR)</label>
                                                <input type="number" class="form-control" value="{{ $item->unit_price }}" readonly tabindex="-1">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Total (LKR)</label>
                                                <input type="text" class="form-control" value="{{ number_format($item->quantity * $item->unit_price, 2) }}" readonly tabindex="-1">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                    <input type="number" class="form-control" id="tax_rate" name="tax_rate" value="{{ $invoice->tax_rate }}" readonly tabindex="-1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span>LKR{{ number_format($invoice->subtotal, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax:</span>
                                            <span>LKR{{ number_format($invoice->tax_amount, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <strong>Total:</strong>
                                            <strong>LKR{{ number_format($invoice->total_amount, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $invoice->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ old('status', $invoice->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ old('status', $invoice->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="cancelled" {{ old('status', $invoice->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
