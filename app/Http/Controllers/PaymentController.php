<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Payment::with(['reservation']);

        // Sorting functionality
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column
        $allowedSortColumns = ['id', 'amount', 'payment_method', 'payment_date', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $payments = $query->paginate(10);

        // Preserve sort parameters in pagination
        if ($request->has('sort')) {
            $payments->appends(['sort' => $request->sort]);
        }
        if ($request->has('order')) {
            $payments->appends(['order' => $request->order]);
        }

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $invoices = Invoice::with(['customer', 'reservation'])->orderBy('invoice_date', 'desc')->get();
        $reservations = \App\Models\Reservation::with('customer')->orderBy('id', 'desc')->get();
        $selectedInvoiceId = $request->get('invoice_id');
        return view('payments.create', compact('invoices', 'reservations', 'selectedInvoiceId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'nullable|exists:invoices,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,cheque',
            'payment_date' => 'required|date',
            // transaction_id is only required for non-cash methods
            'transaction_id' => $request->payment_method === 'cash' ? 'nullable|string|max:100' : 'nullable|string|max:100|unique:payments,transaction_id',
            'notes' => 'nullable|string'
        ]);

        if (empty($validated['invoice_id']) && empty($validated['reservation_id'])) {
            return back()->withErrors(['invoice_id' => 'Please select an invoice or reservation.'])->withInput();
        }

        // If only invoice_id is provided, get reservation_id from invoice
        if (!empty($validated['invoice_id']) && empty($validated['reservation_id'])) {
            $invoice = \App\Models\Invoice::find($validated['invoice_id']);
            if ($invoice && $invoice->reservation_id) {
                $validated['reservation_id'] = $invoice->reservation_id;
            }
        }

        // Set status automatically for cash payments
        if ($validated['payment_method'] === 'cash') {
            $validated['status'] = 'completed';
            $validated['transaction_id'] = null; // Ensure transaction_id is not set for cash
        } else {
            // For other payment methods, set status to 'pending' by default
            $validated['status'] = 'pending';
        }

        $payment = Payment::create($validated);

        // If non-cash payment, set invoice status to 'sent' after payment is created
        if (isset($validated['invoice_id']) && $validated['payment_method'] !== 'cash') {
            $invoice = Invoice::find($validated['invoice_id']);
            if ($invoice) {
                $invoice->status = 'sent';
                $invoice->save();
            }
        }
        // If cash payment and completed, set invoice status to 'paid'
        if (isset($validated['invoice_id']) && $validated['payment_method'] === 'cash' && $validated['status'] === 'completed') {
            $invoice = Invoice::find($validated['invoice_id']);
            if ($invoice) {
                $invoice->status = 'paid';
                $invoice->save();
            }
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $invoices = \App\Models\Invoice::with('customer')->orderBy('invoice_date', 'desc')->get();
        $reservations = \App\Models\Reservation::with('customer')->orderBy('id', 'desc')->get();
        return view('payments.edit', compact('payment', 'invoices', 'reservations'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            // reservation_id is not required since the field is removed from the form
            'reservation_id' => 'nullable|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,cheque',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:100|unique:payments,transaction_id,' . $payment->id,
            'notes' => 'nullable|string'
        ]);

        $payment->update($validated);

        // Update invoice status based on payment status
        if (isset($validated['invoice_id'])) {
            $invoice = Invoice::find($validated['invoice_id']);
            if ($invoice) {
                if ($validated['status'] === 'completed') {
                    $invoice->status = 'paid';
                } elseif ($validated['status'] === 'failed') {
                    $invoice->status = 'overdue';
                } elseif ($validated['status'] === 'refunded') {
                    $invoice->status = 'cancelled';
                }
                $invoice->save();
            }
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['invoice.customer']);
        $pdf = Pdf::loadView('payments.receipt', compact('payment'));
        return $pdf->download('payment-receipt-' . $payment->id . '.pdf');
    }
}
