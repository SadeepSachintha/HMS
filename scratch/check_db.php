<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

if (Schema::hasTable('payments')) {
    echo "Table 'payments' exists.\n";
    $columns = Schema::getColumnListing('payments');
    print_r($columns);
} else {
    echo "Table 'payments' does NOT exist.\n";
}
