<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;
use App\Observers\EventObserver;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $events = Event::all();
        $observer = new EventObserver();

        foreach ($events as $event) {
            // Trigger the generateInvoice logic to generate missing invoices
            $observer->generateInvoice($event);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
