<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Invoice;
use App\Models\Setting;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        $this->generateInvoice($event);
    }

    /**
     * Handle the Event "updated" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        $this->generateInvoice($event);
    }

    /**
     * Generate an invoice for the event if it has a price and doesn't have one yet.
     */
    public function generateInvoice(Event $event): void
    {
        if ($event->price > 0) {
            $subtotal = (float)$event->price;
            
            $settings = Setting::first() ?? new Setting();
            $serviceCharge = $subtotal * ($settings->service_charge_rate ?? 10.00) / 100;
            $sscl = $subtotal * ($settings->sscl_rate ?? 2.50) / 100;
            $tdl = $subtotal * ($settings->tdl_rate ?? 1.00) / 100;
            $vat = $subtotal * ($settings->vat_rate ?? 18.00) / 100;
            $grandTotal = $subtotal + $serviceCharge + $sscl + $tdl + $vat;

            if (!$event->invoice) {
                $invoice = Invoice::create([
                    'customer_id' => $event->customer_id,
                    'event_id' => $event->id,
                    'invoice_date' => now(),
                    'due_date' => $event->start_time ?? now()->addDays(7),
                    'subtotal' => $subtotal,
                    'tax_rate' => ($settings->service_charge_rate ?? 10.00) + ($settings->sscl_rate ?? 2.50) + ($settings->tdl_rate ?? 1.00) + ($settings->vat_rate ?? 18.00),
                    'tax_amount' => $serviceCharge + $sscl + $tdl + $vat,
                    'total_amount' => $grandTotal,
                    'status' => $event->status === 'completed' ? 'paid' : 'sent',
                    'notes' => 'Automatically generated for Event #' . $event->id,
                    'base_amount' => $subtotal,
                    'service_charge' => $serviceCharge,
                    'sscl_amount' => $sscl,
                    'tdl_amount' => $tdl,
                    'vat_amount' => $vat,
                    'grand_total' => $grandTotal,
                ]);

                // Add the main event charge item
                $invoice->items()->create([
                    'description' => 'Event Venue Booking: ' . $event->name,
                    'quantity' => 1,
                    'unit_price' => $subtotal,
                ]);
            } else {
                $invoice = $event->invoice;
                if ($invoice->status !== 'paid') {
                    $invoice->update([
                        'subtotal' => $subtotal,
                        'tax_amount' => $serviceCharge + $sscl + $tdl + $vat,
                        'total_amount' => $grandTotal,
                        'base_amount' => $subtotal,
                        'service_charge' => $serviceCharge,
                        'sscl_amount' => $sscl,
                        'tdl_amount' => $tdl,
                        'vat_amount' => $vat,
                        'grand_total' => $grandTotal,
                    ]);

                    // Update the line item
                    $item = $invoice->items()->where('description', 'LIKE', 'Event Venue Booking:%')->first();
                    if ($item) {
                        $item->update([
                            'description' => 'Event Venue Booking: ' . $event->name,
                            'unit_price' => $subtotal,
                        ]);
                    }
                }
            }
        }
    }
}
