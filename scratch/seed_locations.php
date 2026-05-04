<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use App\Models\Event;
use App\Models\EventLocation;
use Illuminate\Contracts\Console\Kernel;

$app->make(Kernel::class)->bootstrap();

$events = Event::all();
echo "Found " . $events->count() . " events.\n";

foreach ($events as $event) {
    if ($event->location) {
        echo "Processing event: " . $event->name . " (Location: " . $event->location . ")\n";
        $location = EventLocation::firstOrCreate(
            ['name' => $event->location],
            ['status' => 'active']
        );
        $event->location_id = $location->id;
        $event->save();
        echo "Linked to location ID: " . $location->id . "\n";
    } else {
        echo "Event " . $event->name . " has no location string.\n";
    }
}

echo "Seeding complete. Total locations: " . EventLocation::count() . "\n";
