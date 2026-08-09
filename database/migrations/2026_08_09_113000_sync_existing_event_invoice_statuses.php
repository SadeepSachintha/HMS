<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Event;

class SyncExistingEventInvoiceStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Event::all() as $event) {
            if ($event->invoice) {
                $invoice = $event->invoice;
                
                // If invoice is already paid, keep it paid (immutable)
                if ($invoice->status === 'paid') {
                    continue;
                }

                if ($event->status === 'completed') {
                    $invoice->update(['status' => 'paid']);
                } elseif ($event->status === 'cancelled') {
                    $invoice->update(['status' => 'cancelled']);
                } elseif ($invoice->status === 'cancelled' && ($event->status === 'scheduled' || $event->status === 'in_progress')) {
                    $invoice->update(['status' => 'sent']);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No reverse operation needed as this is a data correction migration
    }
}
