<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Reservation;
use App\Models\Customer;
use App\Models\Room;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();

try {
    echo "1. Testing Auto-Invoicing...\n";
    
    $customer = Customer::first() ?? Customer::create(['name' => 'Test User', 'email' => 'test@example.com', 'phone' => '123456789']);
    $room = Room::first() ?? Room::create(['number' => '101', 'room_type_id' => 1, 'status' => 'available']);
    
    $reservation = Reservation::create([
        'customer_id' => $customer->id,
        'room_id' => $room->id,
        'check_in_date' => now(),
        'check_out_date' => now()->addDays(2),
        'number_of_guests' => 2,
        'status' => 'pending'
    ]);
    
    echo "Created Pending Reservation #{$reservation->id}. Checking for invoice...\n";
    $invoiceCount = Invoice::where('reservation_id', $reservation->id)->count();
    echo "Invoice count: $invoiceCount (Expected: 0)\n";
    
    echo "Updating Reservation #{$reservation->id} to 'confirmed'...\n";
    $reservation->update(['status' => 'confirmed']);
    
    $invoice = Invoice::where('reservation_id', $reservation->id)->first();
    if ($invoice) {
        echo "SUCCESS: Invoice #{$invoice->invoice_number} created automatically. Total: {$invoice->total_amount}\n";
    } else {
        echo "FAILURE: Invoice not created.\n";
    }
    
    echo "\n2. Testing Payment Status Sync...\n";
    $payment = Payment::create([
        'reservation_id' => $reservation->id,
        'invoice_id' => $invoice->id,
        'amount' => $invoice->total_amount,
        'payment_date' => now(),
        'payment_method' => 'cash',
        'status' => 'pending'
    ]);
    
    echo "Created Pending Payment for Invoice #{$invoice->invoice_number}. Current Invoice Status: {$invoice->fresh()->status}\n";
    
    echo "Updating Payment to 'completed'...\n";
    $payment->update(['status' => 'completed']);
    
    $updatedInvoice = $invoice->fresh();
    echo "New Invoice Status: {$updatedInvoice->status} (Expected: paid)\n";
    
    if ($updatedInvoice->status === 'paid') {
        echo "SUCCESS: Invoice status synchronized correctly.\n";
    } else {
        echo "FAILURE: Invoice status did not update.\n";
    }

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
} finally {
    DB::rollBack();
    echo "\nTest database changes rolled back.\n";
}
