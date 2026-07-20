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

    /**

     * Display a listing of the payments.

     * 

     * @param \Illuminate\Http\Request $request

     * @return \Illuminate\View\View

     */

    public function index(Request $request)

    {

        $query = Payment::with(['invoice.customer', 'reservation']);

        // Filter for guest users to only show their own payments

        if (auth()->user()->isGuest()) {

            $query->where(function ($q) {

                $q->whereHas('reservation.customer', function ($cq) {

                    $cq->where('email', auth()->user()->email);

                })->orWhereHas('invoice.customer', function ($cq) {

                    $cq->where('email', auth()->user()->email);

                });

            });

        }

        // Apply search filters if present

        if ($request->has('search') && !empty($request->search)) {

            $search = $request->search;

            $query->where(function($q) use ($search) {

                $q->where('id', 'LIKE', "%{$search}%")

                  ->orWhere('amount', 'LIKE', "%{$search}%")

                  ->orWhere('payment_method', 'LIKE', "%{$search}%")

                  ->orWhere('status', 'LIKE', "%{$search}%")

                  ->orWhereHas('invoice', function($invoiceQuery) use ($search) {

                      $invoiceQuery->where('invoice_number', 'LIKE', "%{$search}%")

                                   ->orWhereHas('customer', function($customerQuery) use ($search) {

                                       $customerQuery->where('name', 'LIKE', "%{$search}%");

                                   });

                  });

            });

        }

        // Handle sorting parameters

        $sortBy = $request->get('sort', 'id');

        $sortOrder = $request->get('order', 'desc');

        // Validate sort column against whitelist

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

        // Preserve search and sort parameters in pagination links

        if ($request->has('search')) {

            $payments->appends(['search' => $request->search]);

        }

        if ($request->has('sort')) {

            $payments->appends(['sort' => $request->sort]);

        }

        if ($request->has('order')) {

            $payments->appends(['order' => $request->order]);

        }

        return view('payments.index', compact('payments'));

    }

    /**

     * Show the form for creating a new payment.

     * 

     * @param \Illuminate\Http\Request $request

     * @return \Illuminate\View\View

     */

    public function create(Request $request)

    {

        // Only staff/admin can record payments manually

        if (auth()->user()->isGuest()) {

            abort(403);

        }

        

        $invoices = Invoice::with(['customer', 'reservation'])->orderBy('invoice_date', 'desc')->get();

        $reservations = \App\Models\Reservation::with('customer')->orderBy('id', 'desc')->get();

        $selectedInvoiceId = $request->get('invoice_id');

        

        return view('payments.create', compact('invoices', 'reservations', 'selectedInvoiceId'));

    }

    /**

     * Store a newly created payment in storage.

     * 

     * @param \Illuminate\Http\Request $request

     * @return \Illuminate\Http\RedirectResponse

     */

    public function store(Request $request)

    {

        if (auth()->user()->isGuest()) {

            abort(403);

        }

        

        $validated = $request->validate([

            'invoice_id' => 'nullable|exists:invoices,id',

            'reservation_id' => 'nullable|exists:reservations,id',

            'amount' => 'required|numeric|min:0.01',

            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer',

            'payment_date' => 'required|date',

            // transaction_id is only required for non-cash methods

            'transaction_id' => $request->payment_method === 'cash' ? 'nullable|string|max:100' : 'nullable|string|max:100|unique:payments,transaction_id',

            'notes' => 'nullable|string'

        ]);

        // Validation: At least one link (invoice or reservation) must be provided

        if (empty($validated['invoice_id']) && empty($validated['reservation_id'])) {

            return back()->withErrors(['invoice_id' => 'Please select an invoice or reservation.'])->withInput();

        }

        // If only invoice_id is provided, automatically link to the associated reservation

        // Also ensure amount matches the invoice total (full payment enforcement)

        if (!empty($validated['invoice_id'])) {

            $invoice = \App\Models\Invoice::find($validated['invoice_id']);

            if ($invoice) {

                $validated['amount'] = $invoice->total_amount;

                if (empty($validated['reservation_id']) && $invoice->reservation_id) {

                    $validated['reservation_id'] = $invoice->reservation_id;

                }

            }

        }

        // All payments are marked as completed by default

        $validated['status'] = 'completed';

        if ($validated['payment_method'] === 'cash') {

            $validated['transaction_id'] = null; // No transaction ID for cash

        }

        $payment = Payment::create($validated);

        // Auto-update the linked invoice status to 'paid' when a payment is marked as 'completed'

        if ($payment->status === 'completed' && $payment->invoice) {

            $payment->invoice->update(['status' => 'paid']);

        }

        return redirect()->route('payments.index')

            ->with('success', 'Payment recorded successfully.');

    }

    /**

     * Display the specified payment.

     * 

     * @param \App\Models\Payment $payment

     * @return \Illuminate\View\View

     */

    public function show(Payment $payment)

    {

        $payment->load(['invoice.customer', 'invoice.payments', 'reservation.customer']);

        

        // Ensure guests can only view their own payment records

        if (auth()->user()->isGuest()) {

            $isOwner = false;

            if ($payment->reservation && $payment->reservation->customer->email === auth()->user()->email) $isOwner = true;

            if ($payment->invoice && $payment->invoice->customer->email === auth()->user()->email) $isOwner = true;

            if (!$isOwner) abort(403);

        }

        

        return view('payments.show', compact('payment'));

    }

    /**

     * Show the form for editing the specified payment.

     * 

     * @param \App\Models\Payment $payment

     * @return \Illuminate\View\View

     */

    public function edit(Payment $payment)

    {

        abort(403, 'Editing payments is disabled.');

    }

    /**

     * Update the specified payment in storage.

     * 

     * @param \Illuminate\Http\Request $request

     * @param \App\Models\Payment $payment

     * @return \Illuminate\Http\RedirectResponse

     */

    public function update(Request $request, Payment $payment)

    {

        abort(403, 'Editing payments is disabled.');

    }

    /**

     * Remove the specified payment from storage.

     * 

     * @param \App\Models\Payment $payment

     * @return \Illuminate\Http\RedirectResponse

     */

    public function destroy(Payment $payment)

    {

        abort(403, 'Deletion is disabled.');

    }

    /**

     * Generate and download a PDF receipt for the payment.

     * 

     * @param \App\Models\Payment $payment

     * @return \Illuminate\Http\Response

     */

    public function receipt(Payment $payment)

    {

        $payment->load(['invoice.customer', 'reservation.customer']);

        $pdf = Pdf::loadView('payments.receipt', compact('payment'));

        

        return $pdf->download('payment-receipt-' . $payment->id . '.pdf');

    }

}

