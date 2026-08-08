<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\EventLocation;
use App\Models\Event;
use App\Models\Invoice;

class DashboardStatusFiltersTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $customer;
    protected $roomType;
    protected $location;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();

        $this->customer = Customer::create([
            'name' => 'Test Customer',
            'email' => 'test@customer.com',
            'phone' => '+123456789',
            'nic_passport' => 'NIC123'
        ]);

        $this->roomType = RoomType::create([
            'name' => 'Single Room',
            'price_per_night' => 100.00,
            'capacity' => 1,
            'description' => 'Test'
        ]);

        $this->location = EventLocation::create([
            'name' => 'Grand Hall',
            'capacity' => 100,
            'status' => 'active'
        ]);
    }

    public function test_reservations_status_filtering()
    {
        $room1 = Room::create([
            'number' => 101,
            'room_type_id' => $this->roomType->id,
            'floor' => 1,
            'status' => 'available'
        ]);

        $room2 = Room::create([
            'number' => 102,
            'room_type_id' => $this->roomType->id,
            'floor' => 1,
            'status' => 'available'
        ]);

        // Reservation 1 (Pending)
        $res1 = Reservation::create([
            'customer_id' => $this->customer->id,
            'room_id' => $room1->id,
            'check_in_date' => now()->addDays(1),
            'check_out_date' => now()->addDays(2),
            'number_of_guests' => 1,
            'total_price' => 100.00,
            'status' => 'pending'
        ]);

        // Reservation 2 (Confirmed)
        $res2 = Reservation::create([
            'customer_id' => $this->customer->id,
            'room_id' => $room2->id,
            'check_in_date' => now()->addDays(3),
            'check_out_date' => now()->addDays(4),
            'number_of_guests' => 1,
            'total_price' => 100.00,
            'status' => 'confirmed'
        ]);

        $response = $this->actingAs($this->admin)->get('/reservations?status=confirmed');
        $response->assertStatus(200);
        $response->assertSee('102');
        $response->assertDontSee('101');
    }

    public function test_rooms_status_filtering()
    {
        $availableRoom = Room::create([
            'number' => 201,
            'room_type_id' => $this->roomType->id,
            'floor' => 2,
            'status' => 'available'
        ]);

        $occupiedRoom = Room::create([
            'number' => 202,
            'room_type_id' => $this->roomType->id,
            'floor' => 2,
            'status' => 'occupied'
        ]);

        $response = $this->actingAs($this->admin)->get('/rooms?status=occupied');
        $response->assertStatus(200);
        $response->assertSee('202');
        $response->assertDontSee('201');
    }

    public function test_events_status_filtering()
    {
        // Scheduled Event
        $event1 = Event::create([
            'name' => 'Event Scheduled',
            'start_time' => now()->addDays(1),
            'end_time' => now()->addDays(1)->addHours(2),
            'location_id' => $this->location->id,
            'location' => $this->location->name,
            'customer_id' => $this->customer->id,
            'status' => 'scheduled'
        ]);

        // Completed Event
        $event2 = Event::create([
            'name' => 'Event Completed',
            'start_time' => now()->addDays(3),
            'end_time' => now()->addDays(3)->addHours(2),
            'location_id' => $this->location->id,
            'location' => $this->location->name,
            'customer_id' => $this->customer->id,
            'status' => 'completed'
        ]);

        $response = $this->actingAs($this->admin)->get('/events?status=scheduled');
        $response->assertStatus(200);
        $response->assertSee('Event Scheduled');
        $response->assertDontSee('Event Completed');
    }

    public function test_invoices_status_filtering()
    {
        $invoice1 = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_date' => now(),
            'due_date' => now()->addDays(7),
            'subtotal' => 100.00,
            'tax_rate' => 0.00,
            'tax_amount' => 0.00,
            'total_amount' => 100.00,
            'status' => 'sent'
        ]);

        $invoice2 = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_date' => now(),
            'due_date' => now()->addDays(7),
            'subtotal' => 200.00,
            'tax_rate' => 0.00,
            'tax_amount' => 0.00,
            'total_amount' => 200.00,
            'status' => 'paid'
        ]);

        $response = $this->actingAs($this->admin)->get('/invoices?status=paid');
        $response->assertStatus(200);
        $response->assertSee('LKR200.00');
        $response->assertDontSee('LKR100.00');
    }
}
