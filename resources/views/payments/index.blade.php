@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Payment Records</h2>
        <form method="GET" action="{{ route('payments.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2"
                   placeholder="Search by ID, amount, method, status, invoice, or customer..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    @if(request('search'))
        <div class="alert alert-info">
            <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
            <a href="{{ route('payments.index') }}" class="float-end">Clear search</a>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('sort') == 'id' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    ID
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'id' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'id' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>Invoice</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount', 'order' => request('sort') == 'amount' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Amount
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'amount' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'amount' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'payment_method', 'order' => request('sort') == 'payment_method' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Method
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'payment_method' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'payment_method' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                    </div>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'payment_date', 'order' => request('sort') == 'payment_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                   class="text-decoration-none text-white d-flex align-items-center justify-content-between">
                                    Date
                                    <div class="d-flex flex-column">
                                        <i class="fas fa-sort-up {{ request('sort') == 'payment_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                        <i class="fas fa-sort-down {{ request('sort') == 'payment_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
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
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>
                                    @if($payment->invoice)
                                        <a href="{{ route('invoices.show', $payment->invoice_id) }}">
                                            #{{ $payment->invoice->invoice_number }}
                                        </a>
                                    @else
                                        &mdash;
                                    @endif
                                </td>
                                <td>LKR{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->payment_method === 'check' ? 'Cheque' : ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td>{{ $payment->payment_date->format('Y-m-d H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : ($payment->status === 'failed' ? 'danger' : 'info')) }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this payment record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No payment records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $payments->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
