<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailedTaxFieldsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('base_amount', 12, 2)->default(0.00)->after('notes');
            $table->decimal('service_charge', 12, 2)->default(0.00)->after('base_amount');
            $table->decimal('sscl_amount', 12, 2)->default(0.00)->after('service_charge');
            $table->decimal('tdl_amount', 12, 2)->default(0.00)->after('sscl_amount');
            $table->decimal('vat_amount', 12, 2)->default(0.00)->after('tdl_amount');
            $table->decimal('grand_total', 12, 2)->default(0.00)->after('vat_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['base_amount', 'service_charge', 'sscl_amount', 'tdl_amount', 'vat_amount', 'grand_total']);
        });
    }
}
