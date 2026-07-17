<?php

namespace App\Observers;

use App\Models\Payment;

/**
 * Class PaymentObserver
 * 
 * Monitors payment records and automatically synchronizes the status of the associated
 * invoice when a payment's status changes (e.g. marking it paid, overdue, or cancelled).
 * 
 * @package App\Observers
 */
class PaymentObserver
{
    /**
     * Handle the Payment "saved" event (covers creation and updating).
     * Synchronizes the associated invoice's status based on the payment outcome.
     * 
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function saved(Payment $payment): void
    {
        if ($payment->invoice) {
            switch ($payment->status) {
                case 'completed':
                    // Successful full payments mark the invoice as Paid
                    $payment->invoice->update(['status' => 'paid']);

                    // Automatically confirm the associated reservation if it's currently pending
                    if ($payment->invoice->reservation && $payment->invoice->reservation->status === 'pending') {
                        $payment->invoice->reservation->update(['status' => 'confirmed']);
                    }
                    break;
                case 'failed':
                    // Unsuccessful payments tag the invoice as Overdue
                    $payment->invoice->update(['status' => 'overdue']);
                    break;
                case 'refunded':
                    // Reversals/refunds cancel the invoice validity
                    $payment->invoice->update(['status' => 'cancelled']);
                    break;
            }
        }

        // Also check if payment is linked directly to a reservation
        if ($payment->status === 'completed' && $payment->reservation && $payment->reservation->status === 'pending') {
            $payment->reservation->update(['status' => 'confirmed']);
        }
    }

    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
