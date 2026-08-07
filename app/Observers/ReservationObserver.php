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
        $this->syncRoomStatus($reservation);
        $this->notifyStaff($reservation);
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
        $this->syncRoomStatus($reservation);
    }

    /**
     * Generate an invoice for the reservation if it's confirmed and doesn't have one.
     */
    private function generateInvoice(Reservation $reservation): void
    {
        if ($reservation->status === 'confirmed' && !$reservation->invoice) {
            $subtotal = $reservation->total_price;
            
            $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
            $serviceCharge = $subtotal * ($settings->service_charge_rate ?? 10.00) / 100;
            $sscl = $subtotal * ($settings->sscl_rate ?? 2.50) / 100;
            $tdl = $subtotal * ($settings->tdl_rate ?? 1.00) / 100;
            $vat = $subtotal * ($settings->vat_rate ?? 18.00) / 100;
            $grandTotal = $subtotal + $serviceCharge + $sscl + $tdl + $vat;

            \App\Models\Invoice::create([
                'customer_id' => $reservation->customer_id,
                'reservation_id' => $reservation->id,
                'invoice_date' => now(),
                'due_date' => now()->addDays(7), // Standard 7 days due date
                'subtotal' => $subtotal,
                'tax_rate' => ($settings->service_charge_rate ?? 10.00) + ($settings->sscl_rate ?? 2.50) + ($settings->tdl_rate ?? 1.00) + ($settings->vat_rate ?? 18.00),
                'tax_amount' => $serviceCharge + $sscl + $tdl + $vat,
                'total_amount' => $grandTotal,
                'status' => 'sent',
                'notes' => 'Automatically generated for Reservation #' . $reservation->id,
                'base_amount' => $subtotal,
                'service_charge' => $serviceCharge,
                'sscl_amount' => $sscl,
                'tdl_amount' => $tdl,
                'vat_amount' => $vat,
                'grand_total' => $grandTotal,
            ]);
        }
    }

    /**
     * Automatically update the room's status based on the reservation status.
     */
    private function syncRoomStatus(Reservation $reservation): void
    {
        if (!$reservation->room) {
            return;
        }

        if ($reservation->status === 'checked_in') {
            $reservation->room->update(['status' => 'occupied']);
        } elseif ($reservation->status === 'checked_out') {
            $reservation->room->update(['status' => 'available']);
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

    /**
     * Send notifications to staff, manager, and admin users.
     */
    private function notifyStaff(Reservation $reservation): void
    {
        $creator = auth()->user();
        $isGuestCreated = $creator && $creator->isGuest();
        
        $title = $isGuestCreated ? 'New Guest Booking' : 'New Booking Registered';
        $customerName = $reservation->customer->name ?? 'Guest';
        $roomNumber = $reservation->room->number ?? 'TBD';
        
        $message = $isGuestCreated 
            ? "Guest {$customerName} has booked Room {$roomNumber}."
            : "Staff member " . ($creator->name ?? 'System') . " registered a booking for {$customerName} in Room {$roomNumber}.";

        $staffUsers = \App\Models\User::whereIn('role', ['admin', 'manager', 'staff'])->get();
        foreach ($staffUsers as $user) {
            \App\Models\Alert::create([
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'type' => 'info',
                'link' => route('reservations.show', $reservation),
                'is_read' => false
            ]);
        }
    }
}
