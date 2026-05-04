@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Invoices</h2>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('invoices.index') }}" class="d-flex me-3">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                       placeholder="Search by invoice #, customer, or status..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Invoice
            </a>
        </div>
    </div>

    @if(request('search'))
        <div class="alert alert-info">
            <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
            <a href="{{ route('invoices.index') }}" class="float-end">Clear search</a>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'invoice_number', 'order' => request('sort') == 'invoice_number' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Invoice #
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'invoice_number' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'invoice_number' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>Customer</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'issue_date', 'order' => request('sort') == 'issue_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Issue Date
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'issue_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'issue_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'due_date', 'order' => request('sort') == 'due_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Due Date
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'due_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'due_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'total', 'order' => request('sort') == 'total' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Amount
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'total' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'total' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('sort') == 'status' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Status
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'status' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'status' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-end" style="width: 1%; white-space: nowrap;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->customer->name }}</td>
                                <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : '' }}</td>
                                <td>{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '' }}</td>
                                <td>LKR{{ number_format($invoice->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'pending' ? 'warning' : ($invoice->status === 'overdue' ? 'danger' : 'info')) }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning" title="Edit Status & Notes">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                                            <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-sm btn-success" title="Pay">
                                                <i class="fas fa-credit-card"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" title="Pay" disabled style="pointer-events: none; opacity: 0.65;">
                                                <i class="fas fa-credit-card"></i>
                                            </button>
                                        @endif
                                        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-sm btn-secondary" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    @if(request('search'))
                                        No invoices found matching your search criteria.
                                    @else
                                        No invoices found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
