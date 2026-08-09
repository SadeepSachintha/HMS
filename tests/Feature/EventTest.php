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
                'customer_id' => $this->customer->id,
                'status' => 'completed'
            ]);

        $response->assertRedirect('/events');
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => 'Updated Seeded Event'
        ]);
    }

    /**
     * Test that updating an event's price saves successfully and updates its invoice.
     */
    public function test_updating_event_price_succeeds_and_syncs_invoice()
    {
        $startTime = now()->addDays(5)->format('Y-m-d H:i:s');
        $endTime = now()->addDays(5)->addHours(3)->format('Y-m-d H:i:s');

        // Create an event with price 0 (no invoice generated yet)
        $response = $this->actingAs($this->adminUser)
            ->post('/events', [
                'name' => 'Wedding Gala',
                'description' => 'A grand wedding celebration',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location_id' => $this->location->id,
                'max_attendees' => 150,
                'price' => 0.00,
                'customer_id' => $this->customer->id,
                'status' => 'scheduled'
            ]);

        $event = Event::where('name', 'Wedding Gala')->first();
        $this->assertNotNull($event);
        $this->assertEquals(0.00, $event->price);
        $this->assertNull($event->invoice);

        // Update the event's price to 2500 (this triggers invoice generation because event is unlocked)
        $response = $this->actingAs($this->adminUser)
            ->put("/events/{$event->id}", [
                'name' => 'Wedding Gala Updated',
                'description' => 'A grand wedding celebration',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location_id' => $this->location->id,
                'customer_id' => $this->customer->id,
                'price' => 2500.00,
                'status' => 'scheduled'
            ]);

        $response->assertRedirect('/events');
        $event->refresh();

        // Assert price saved successfully in event
        $this->assertEquals(2500.00, $event->price);
        $this->assertEquals('Wedding Gala Updated', $event->name);

        // Assert invoice is generated
        $invoice = $event->invoice;
        $this->assertNotNull($invoice);
        $this->assertEquals(2500.00, $invoice->subtotal);

        // Assert invoice items updated
        $item = $invoice->items()->where('description', 'LIKE', 'Event Venue Booking:%')->first();
        $this->assertNotNull($item);
        $this->assertEquals(2500.00, $item->unit_price);
        $this->assertEquals('Event Venue Booking: Wedding Gala Updated', $item->description);

        // Cancel the event and verify the invoice status is updated to cancelled
        $response = $this->actingAs($this->adminUser)
            ->put("/events/{$event->id}", [
                'name' => 'Wedding Gala Updated',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location_id' => $this->location->id,
                'customer_id' => $this->customer->id,
                'status' => 'cancelled'
            ]);
        $invoice->refresh();
        $this->assertEquals('cancelled', $invoice->status);

        // Complete the event and verify the invoice status is updated to paid
        $response = $this->actingAs($this->adminUser)
            ->put("/events/{$event->id}", [
                'name' => 'Wedding Gala Updated',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location_id' => $this->location->id,
                'customer_id' => $this->customer->id,
                'status' => 'completed'
            ]);
        $invoice->refresh();
        $this->assertEquals('paid', $invoice->status);
    }

    /**
     * Test that if an invoice is already generated, core event details (price, name, etc.) are locked.
     */
    public function test_event_fields_are_locked_when_invoice_exists()
    {
        $startTime = now()->addDays(5)->format('Y-m-d H:i:s');
        $endTime = now()->addDays(5)->addHours(3)->format('Y-m-d H:i:s');

        // 1. Create an event (which triggers invoice generation since price is > 0)
        $event = Event::create([
            'name' => 'Locked Event',
            'description' => 'Original description',
            'start_time' => now()->addDays(2),
            'end_time' => now()->addDays(2)->addHours(2),
            'location_id' => $this->location->id,
            'location' => $this->location->name,
            'max_attendees' => 10,
            'price' => 500.00,
            'customer_id' => $this->customer->id,
            'status' => 'scheduled'
        ]);

        $event->refresh();
        $this->assertNotNull($event->invoice);

        // 2. Attempt to update name and price (should be ignored) but change notes and status (should be allowed)
        $response = $this->actingAs($this->adminUser)
            ->put("/events/{$event->id}", [
                'name' => 'Should Be Ignored',
                'price' => 9999.00,
                'notes' => 'New allowed notes',
                'status' => 'cancelled'
            ]);

        $response->assertRedirect('/events');
        $event->refresh();

        // Core fields should remain original
        $this->assertEquals('Locked Event', $event->name);
        $this->assertEquals(500.00, $event->price);

        // Mutable fields should be updated
        $this->assertEquals('New allowed notes', $event->notes);
        $this->assertEquals('cancelled', $event->status);
    }
}