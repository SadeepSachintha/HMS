<?php

namespace App\Observers;

use App\Models\Reservation;

class ReservationObserver
{
    /**
     * Handle the Reservation "created" event.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function created(Reservation $reservation)
    {
        $this->generateInvoice($reservation);
    }

    /**
     * Handle the Reservation "updated" event.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function updated(Reservation $reservation)
    {
        $this->generateInvoice($reservation);
    }

    /**
     * Generate an invoice for the reservation if it's confirmed and doesn't have one.
     */
    private function generateInvoice(Reservation $reservation): void
    {
        if ($reservation->status === 'confirmed' && !$reservation->invoice) {
            $total = $reservation->total_price;
            
            \App\Models\Invoice::create([
                'customer_id' => $reservation->customer_id,
                'reservation_id' => $reservation->id,
                'invoice_date' => now(),
                'due_date' => now()->addDays(7), // Standard 7 days due date
                'subtotal' => $total,
                'tax_rate' => 0,
                'tax_amount' => 0,
                'total_amount' => $total,
                'status' => 'sent',
                'notes' => 'Automatically generated for Reservation #' . $reservation->id
            ]);
        }
    }

    /**
     * Handle the Reservation "deleted" event.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function deleted(Reservation $reservation)
    {
        //
    }

    /**
     * Handle the Reservation "restored" event.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function restored(Reservation $reservation)
    {
        //
    }

    /**
     * Handle the Reservation "force deleted" event.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function forceDeleted(Reservation $reservation)
    {
        //
    }
}
