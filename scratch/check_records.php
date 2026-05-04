<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Reservation;

$res = Reservation::orderBy('check_in_date', 'asc')->get(['id', 'check_in_date', 'check_out_date']);
foreach ($res as $r) {
    echo "ID: {$r->id} | Check-in: {$r->check_in_date} | Check-out: {$r->check_out_date}\n";
}
