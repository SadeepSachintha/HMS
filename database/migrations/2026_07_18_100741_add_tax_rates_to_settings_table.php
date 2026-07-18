<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxRatesToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('service_charge_rate', 5, 2)->default(10.00)->after('sms_notifications');
            $table->decimal('sscl_rate', 5, 2)->default(2.50)->after('service_charge_rate');
            $table->decimal('tdl_rate', 5, 2)->default(1.00)->after('sscl_rate');
            $table->decimal('vat_rate', 5, 2)->default(18.00)->after('tdl_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['service_charge_rate', 'sscl_rate', 'tdl_rate', 'vat_rate']);
        });
    }
}
