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
        $allowedSortColumns = ['id', 'invoice_number', 'issue_date', 'due_date', 'total', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $invoices = $query->paginate(10);

        // Preserve search and sort parameters in pagination
        if ($request->has('search')) {
            $invoices->appends(['search' => $request->search]);
        }
        if ($request->has('sort')) {
            $invoices->appends(['sort' => $request->sort]);
        }
        if ($request->has('order')) {
            $invoices->appends(['order' => $request->order]);
        }

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = \App\Models\Customer::orderBy('name')->get();
        $events = \App\Models\Event::orderBy('start_time', 'desc')->get();
        $reservations = \App\Models\Reservation::with(['customer', 'room.roomType'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDoesntHave('invoice')
            ->orderBy('id', 'desc')
            ->get();
        return view('invoices.create', compact('customers', 'events', 'reservations'));
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
            'notes' => 'nullable|string'
        ]);

        $invoice = Invoice::create($validated);

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

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $customers = \App\Models\Customer::orderBy('name')->get();
        $events = \App\Models\Event::orderBy('start_time', 'desc')->get();
        return view('invoices.edit', compact('invoice', 'customers', 'events'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'event_id' => 'nullable|exists:events,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'subtotal' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string'
        ]);

        $invoice->update($validated);

        // Remove old items
        $invoice->items()->delete();

        // Add new items
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

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
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
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }
    //PDF generation and download
    public function download(Invoice $invoice)
    {
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice_' . $invoice->id . '.pdf');
    }
}
