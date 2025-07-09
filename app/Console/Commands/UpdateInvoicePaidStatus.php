<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;

class UpdateInvoicePaidStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:update-paid-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all invoices with at least one completed payment to status paid';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Invoice::whereHas('payments', function($q) {
            $q->where('status', 'completed');
        })->update(['status' => 'paid']);

        $this->info("Updated {$count} invoice(s) to status 'paid'.");
    }
}
