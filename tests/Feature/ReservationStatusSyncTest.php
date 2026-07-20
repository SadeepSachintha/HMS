<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ReservationStatusSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_room_status_changes_to_occupied_when_checked_in()
    {
        $roomType = RoomType::create([
            'name' => 'Deluxe Room',
            'description' => 'A luxury room',
            'price_per_night' => 150.00,
            'capacity' => 2,
            'amenities' => ['Wi-Fi', 'TV']
        ]);

        $room = Room::create([
            'number' => '102',
            'room_type_id' => $roomType->id,
            'floor' => 1,
            'status' => 'available',
            'is_clean' => true
        ]);

        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@doe.com',
            'phone' => '0987654321',
            'address' => '456 Oak St'
        ]);

        $reservation = Reservation::create([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 2,
            'status' => 'confirmed'
        ]);

        $this->assertEquals('available', $room->fresh()->status);

        // Update status to checked_in
        $reservation->update(['status' => 'checked_in']);

        $this->assertEquals('occupied', $room->fresh()->status);
    }

    public function test_room_status_changes_to_available_when_checked_out()
    {
        $roomType = RoomType::create([
            'name' => 'Deluxe Room',
            'description' => 'A luxury room',
            'price_per_night' => 150.00,
            'capacity' => 2,
            'amenities' => ['Wi-Fi', 'TV']
        ]);

        $room = Room::create([
            'number' => '102',
            'room_type_id' => $roomType->id,
            'floor' => 1,
            'status' => 'occupied',
            'is_clean' => true
        ]);

        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@doe.com',
            'phone' => '0987654321',
            'address' => '456 Oak St'
        ]);

        $reservation = Reservation::create([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 2,
            'status' => 'checked_in'
        ]);

        $this->assertEquals('occupied', $room->fresh()->status);

        // Update status to checked_out
        $reservation->update(['status' => 'checked_out']);

        $this->assertEquals('available', $room->fresh()->status);
    }

    public function test_reservation_auto_checks_out_on_checkout_date_if_invoice_is_paid()
    {
        // Freeze time to 9:00 AM on today
        Carbon::setTestNow(Carbon::parse('2026-07-20 09:00:00'));

        $roomType = RoomType::create([
            'name' => 'Deluxe Room',
            'description' => 'A luxury room',
            'price_per_night' => 150.00,
            'capacity' => 2,
            'amenities' => ['Wi-Fi', 'TV']
        ]);

        $room = Room::create([
            'number' => '102',
            'room_type_id' => $roomType->id,
            'floor' => 1,
            'status' => 'occupied',
            'is_clean' => true
        ]);

        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@doe.com',
            'phone' => '0987654321',
            'address' => '456 Oak St'
        ]);

        $reservation = Reservation::create([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'check_in_date' => Carbon::parse('2026-07-18')->toDateString(),
            'check_out_date' => Carbon::parse('2026-07-20')->toDateString(), // Checkout date is today!
            'number_of_guests' => 2,
            'status' => 'checked_in'
        ]);

        // Create an invoice and set its status to paid
        $invoice = \App\Models\Invoice::create([
            'customer_id' => $customer->id,
            'reservation_id' => $reservation->id,
            'invoice_date' => Carbon::parse('2026-07-20')->toDateString(),
            'due_date' => Carbon::parse('2026-07-27')->toDateString(),
            'subtotal' => 300.00,
            'tax_rate' => 0.00,
            'tax_amount' => 0.00,
            'total_amount' => 300.00,
            'status' => 'paid',
            'base_amount' => 300.00,
            'grand_total' => 300.00
        ]);

        $user = User::factory()->create(['role' => 'admin']);

        // 1. Make request at 9:00 AM (before default 12:00 PM checkout time)
        $response = $this->actingAs($user)->get(route('dashboard'));

        // Should NOT be checked out yet
        $this->assertEquals('checked_in', $reservation->fresh()->status);
        $this->assertEquals('occupied', $room->fresh()->status);

        // 2. Advance time to 1:00 PM (after 12:00 PM checkout time)
        Carbon::setTestNow(Carbon::parse('2026-07-20 13:00:00'));

        $response = $this->actingAs($user)->get(route('dashboard'));

        // Should now be checked out and room status set to available
        $this->assertEquals('checked_out', $reservation->fresh()->status);
        $this->assertEquals('available', $room->fresh()->status);

        // Clean up time mocking
        Carbon::setTestNow();
    }
}
