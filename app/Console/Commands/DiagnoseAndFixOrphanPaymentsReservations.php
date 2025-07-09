<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Reservation;

class DiagnoseAndFixOrphanPaymentsReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:fix-orphan-report-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose and fix orphaned payments and reservations for reports (removes payments with no reservation and reservations with no customer)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- Checking and Deleting Orphaned Payments (no valid reservation) ---');
        $orphanPayments = Payment::whereNull('reservation_id')
            ->orWhereDoesntHave('reservation')
            ->get();
        if ($orphanPayments->isEmpty()) {
            $this->info('No orphaned payments found.');
        } else {
            foreach ($orphanPayments as $payment) {
                $this->line("Deleting Payment ID {$payment->id} (Amount: {$payment->amount}) - no valid reservation.");
                $payment->delete();
            }
        }

        $this->info('--- Checking and Deleting Orphaned Reservations (no valid customer) ---');
        $orphanReservations = Reservation::whereNull('customer_id')
            ->orWhereDoesntHave('customer')
            ->get();
        if ($orphanReservations->isEmpty()) {
            $this->info('No orphaned reservations found.');
        } else {
            foreach ($orphanReservations as $reservation) {
                $this->line("Deleting Reservation ID {$reservation->id} (Room: {$reservation->room_id}) - no valid customer.");
                $reservation->delete();
            }
        }
        $this->info('--- Done ---');
    }
}
