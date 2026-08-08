<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\EventLocation;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $customer;
    protected $location;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'nic_passport' => 'NIC123456'
        ]);

        $this->location = EventLocation::create([
            'name' => 'Main Ballroom',
            'capacity' => 200,
            'status' => 'active'
        ]);
    }

    /**
     * Test creating an event with a future date succeeds.
     */
    public function test_creating_event_with_future_date_succeeds()
    {
        $startTime = now()->addDays(5)->format('Y-m-d H:i:s');
        $endTime = now()->addDays(5)->addHours(3)->format('Y-m-d H:i:s');

        $response = $this->actingAs($this->adminUser)
            ->post('/events', [
                'name' => 'Wedding Gala',
                'description' => 'A grand wedding celebration',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location_id' => $this->location->id,
                'max_attendees' => 150,
                'price' => 5000.00,
                'customer_id' => $this->customer->id,
                'status' => 'scheduled'
            ]);

        $response->assertRedirect('/events');
        $this->assertDatabaseHas('events', [
            'name' => 'Wedding Gala',
            'location_id' => $this->location->id
        ]);

        $event = Event::where('name', 'Wedding Gala')->first();
        $this->assertNotNull($event);

        $this->assertDatabaseHas('invoices', [
            'event_id' => $event->id,
            'customer_id' => $this->customer->id,
            'subtotal' => 5000.00
        ]);

        $invoice = $event->invoice;
        $this->assertNotNull($invoice);

        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'description' => 'Event Venue Booking: Wedding Gala',
            'unit_price' => 5000.00,
            'quantity' => 1
        ]);
    }

    /**
     * Test creating an event with a past date fails validation.
     */
    public function test_creating_event_with_past_date_fails()
    {
        $startTime = now()->subDays(2)->format('Y-m-d H:i:s');
        $endTime = now()->subDays(2)->addHours(3)->format('Y-m-d H:i:s');

        $response = $this->actingAs($this->adminUser)
            ->post('/events', [
                'name' => 'Past Banquet',
                'description' => 'Past event test',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location_id' => $this->location->id,
                'max_attendees' => 50,
                'price' => 1500.00,
                'customer_id' => $this->customer->id,
                'status' => 'scheduled'
            ]);

        $response->assertSessionHasErrors('start_time');
        $this->assertDatabaseMissing('events', [
            'name' => 'Past Banquet'
        ]);
    }

    /**
     * Test updating an event that already has a past start date works without forcing date migration.
     */
    public function test_updating_event_with_past_date_succeeds()
    {
        // Bypass validation to seed a past event
        $event = Event::create([
            'name' => 'Seeded Event',
            'start_time' => now()->subDays(5),
            'end_time' => now()->subDays(5)->addHours(2),
            'location_id' => $this->location->id,
            'location' => $this->location->name,
            'customer_id' => $this->customer->id,
            'status' => 'completed'
        ]);

        $response = $this->actingAs($this->adminUser)
            ->put("/events/{$event->id}", [
                'name' => 'Updated Seeded Event',
                'start_time' => $event->start_time->format('Y-m-d H:i:s'),
                'end_time' => $event->end_time->format('Y-m-d H:i:s'),
                'location_id' => $this->location->id,
                'status' => 'completed'
            ]);

        $response->assertRedirect('/events');
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => 'Updated Seeded Event'
        ]);
    }
}
