<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller

{

    public function __construct()

    {

        $this->middleware('auth');

    }

    public function index(Request $request)

    {

        $query = Invoice::with(['customer']);

        // Filter results for guest users to only show their own invoices

        if (auth()->user()->isGuest()) {

            $query->whereHas('customer', function($q) {

                $q->where('email', auth()->user()->email);

            });

        }

        // Search functionality

        if ($request->has('search') && !empty($request->search)) {

            $search = $request->search;

            $query->where(function($q) use ($search) {

                $q->where('invoice_number', 'LIKE', "%{$search}%")

                  ->orWhere('status', 'LIKE', "%{$search}%")

                  ->orWhereHas('customer', function($customerQuery) use ($search) {

                      $customerQuery->where('name', 'LIKE', "%{$search}%");

                  });

            });

        }

        // Sorting functionality

        $sortBy = $request->get('sort', 'id');

        $sortOrder = $request->get('order', 'desc');

        // Validate sort column

        $allowedSortColumns = ['id', 'invoice_number', 'invoice_date', 'due_date', 'total_amount', 'status', 'created_at'];

        if (!in_array($sortBy, $allowedSortColumns)) {

            $sortBy = 'id';

        }

        // Validate sort order

        if (!in_array($sortOrder, ['asc', 'desc'])) {

            $sortOrder = 'desc';

        }

        // Apply status filter if present
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $query->orderBy($sortBy, $sortOrder);

        $invoices = $query->paginate(10);

        // Preserve search and sort parameters in pagination

        if ($request->has('search')) {

            $invoices->appends(['search' => $request->search]);

        }
        if ($request->has('status')) {
            $invoices->appends(['status' => $request->status]);
        }

        if ($request->has('sort')) {

            $invoices->appends(['sort' => $request->sort]);

        }

        if ($request->has('order')) {

            $invoices->appends(['order' => $request->order]);

        }

        return view('invoices.index', compact('invoices'));

    }

    public function create(Request $request)

    {

        $customers = \App\Models\Customer::orderBy('name')->get();

        $events = \App\Models\Event::whereIn('status', ['scheduled', 'in_progress'])

            ->whereDoesntHave('invoice')

            ->orderBy('start_time', 'desc')->get();

        $reservations = \App\Models\Reservation::with(['customer', 'room.roomType'])

            ->whereIn('status', ['pending', 'confirmed', 'checked_in', 'checked_out'])

            ->whereDoesntHave('invoice')

            ->orderBy('id', 'desc')

            ->get();

        $foodItems = \App\Models\FoodItem::where('is_available', 1)->orderBy('name')->get();

        $preselectedCustomerId = $request->query('customer_id');

        $preselectedReservationId = $request->query('reservation_id');

        $preselectedEventId = $request->query('event_id');

        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();

        return view('invoices.create', compact(

            'customers', 'events', 'reservations', 'foodItems',

            'preselectedCustomerId', 'preselectedReservationId', 'preselectedEventId', 'settings'

        ));

    }

    public function store(Request $request)

    {

        $validated = $request->validate([

            'customer_id' => 'required|exists:customers,id',

            'event_id' => 'nullable|exists:events,id',

            'reservation_id' => 'nullable|exists:reservations,id',

            'invoice_date' => 'required|date',

            'due_date' => 'required|date|after:invoice_date',

            'subtotal' => 'required|numeric|min:0',

            'tax_rate' => 'required|numeric|min:0',

            'tax_amount' => 'required|numeric|min:0',

            'total_amount' => 'required|numeric|min:0',

            'notes' => 'nullable|string',

            // Main charge fields

            'main_charge' => 'nullable|array',

            'main_charge.description' => 'nullable|string',

            'main_charge.quantity' => 'nullable|integer|min:1',

            'main_charge.unit_price' => 'nullable|numeric|min:0',

            // Instant payment recording fields

            'record_payment' => 'nullable|boolean',

            'payment_method' => 'required_if:record_payment,1|nullable|string|in:cash,credit_card,debit_card,bank_transfer',

            'amount_paid' => 'required_if:record_payment,1|nullable|numeric|min:0'

        ]);

        // Prevent duplicate invoice for reservation

        if (!empty($validated['reservation_id'])) {

            $existingInvoice = \App\Models\Invoice::where('reservation_id', $validated['reservation_id'])->first();

            if ($existingInvoice) {

                return redirect()->back()->withInput()->withErrors(['reservation_id' => 'An invoice already exists for the selected reservation.']);

            }

        }

        // Fetch settings for dynamic tax calculation

        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();

        $subtotal = (float)$validated['subtotal'];

        $serviceCharge = $subtotal * ($settings->service_charge_rate ?? 10.00) / 100;

        $sscl = $subtotal * ($settings->sscl_rate ?? 2.50) / 100;

        $tdl = $subtotal * ($settings->tdl_rate ?? 1.00) / 100;

        $vat = $subtotal * ($settings->vat_rate ?? 18.00) / 100;

        $grandTotal = $subtotal + $serviceCharge + $sscl + $tdl + $vat;

        // We create the invoice. We don't save record_payment, payment_method, amount_paid, and main_charge to invoice model directly

        $invoiceData = collect($validated)->except(['record_payment', 'payment_method', 'amount_paid', 'main_charge'])->toArray();

        

        $invoiceData['base_amount'] = $subtotal;

        $invoiceData['service_charge'] = $serviceCharge;

        $invoiceData['sscl_amount'] = $sscl;

        $invoiceData['tdl_amount'] = $tdl;

        $invoiceData['vat_amount'] = $vat;

        $invoiceData['grand_total'] = $grandTotal;

        // Legacy compatibility

        $invoiceData['subtotal'] = $subtotal;

        $invoiceData['tax_rate'] = ($settings->service_charge_rate ?? 10.00) + ($settings->sscl_rate ?? 2.50) + ($settings->tdl_rate ?? 1.00) + ($settings->vat_rate ?? 18.00);

        $invoiceData['tax_amount'] = $serviceCharge + $sscl + $tdl + $vat;

        $invoiceData['total_amount'] = $grandTotal;

        $invoice = Invoice::create($invoiceData);

        // Save main charge as invoice item

        if ($request->has('main_charge')) {

            $mainCharge = $request->input('main_charge');

            if (!empty($mainCharge['description']) && !empty($mainCharge['quantity']) && isset($mainCharge['unit_price'])) {

                $invoice->items()->create([

                    'description' => $mainCharge['description'],

                    'quantity' => $mainCharge['quantity'],

                    'unit_price' => $mainCharge['unit_price'],

                ]);

            }

        }

        // Save invoice items

        if ($request->has('items')) {

            foreach ($request->items as $item) {

                if (!empty($item['description']) && !empty($item['quantity']) && !empty($item['unit_price'])) {

                    $invoice->items()->create([

                        'description' => $item['description'],

                        'quantity' => $item['quantity'],

                        'unit_price' => $item['unit_price'],

                    ]);

                }

            }

        }

        // Create instant payment if requested

        if ($request->boolean('record_payment')) {

            \App\Models\Payment::create([

                'invoice_id' => $invoice->id,

                'reservation_id' => $validated['reservation_id'] ?? null,

                'amount' => $validated['amount_paid'],

                'payment_method' => $validated['payment_method'],

                'payment_date' => now(),

                'status' => 'completed',

                'notes' => 'Auto-recorded during invoice creation.'

            ]);

            $invoice->update(['status' => 'paid']);

        }

        return redirect()->route('invoices.index')

            ->with('success', 'Invoice created successfully.');

    }

    public function show(Invoice $invoice)

    {

        if (auth()->user()->isGuest() && $invoice->customer->email !== auth()->user()->email) {

            abort(403);

        }

        return view('invoices.show', compact('invoice'));

    }

    public function edit(Invoice $invoice)

    {

        abort(403, 'Editing invoices is disabled.');

    }

    public function update(Request $request, Invoice $invoice)

    {

        abort(403, 'Editing invoices is disabled.');

    }

    public function updateStatusNotes(Request $request, Invoice $invoice)

    {

        $validated = $request->validate([

            'status' => 'required|in:draft,sent,paid,overdue,cancelled',

            'notes' => 'nullable|string'

        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice)

            ->with('success', 'Invoice status and notes updated successfully.');

    }

    public function destroy(Invoice $invoice)

    {

        abort(403, 'Deletion is disabled.');

    }

    //PDF generation and download

    public function download(Invoice $invoice)

    {

        if (auth()->user()->isGuest() && $invoice->customer->email !== auth()->user()->email) {

            abort(403);

        }

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('invoice_' . $invoice->id . '.pdf');

    }

}

