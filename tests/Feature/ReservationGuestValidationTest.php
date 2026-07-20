<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationGuestValidationTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $customer;
    private $singleRoom;
    private $doubleRoom;
    private $deluxeFamilyRoom;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '1234567890',
            'address' => '123 Main St'
        ]);

        $singleType = RoomType::create([
            'name' => 'Single Room',
            'description' => 'Single Room description',
            'price_per_night' => 100.00,
            'capacity' => 1
        ]);

        $doubleType = RoomType::create([
            'name' => 'Double Room',
            'description' => 'Double Room description',
            'price_per_night' => 200.00,
            'capacity' => 2
        ]);

        $deluxeFamilyType = RoomType::create([
            'name' => 'Deluxe Family Room',
            'description' => 'Deluxe Family Room description',
            'price_per_night' => 400.00,
            'capacity' => 4
        ]);

        $this->singleRoom = Room::create([
            'number' => '101',
            'room_type_id' => $singleType->id,
            'floor' => 1,
            'status' => 'available',
            'is_clean' => true
        ]);

        $this->doubleRoom = Room::create([
            'number' => '201',
            'room_type_id' => $doubleType->id,
            'floor' => 2,
            'status' => 'available',
            'is_clean' => true
        ]);

        $this->deluxeFamilyRoom = Room::create([
            'number' => '301',
            'room_type_id' => $deluxeFamilyType->id,
            'floor' => 3,
            'status' => 'available',
            'is_clean' => true
        ]);
    }

    public function test_single_room_exceeding_capacity_validation()
    {
        // 1 guest is allowed
        $response = $this->actingAs($this->admin)->post(route('reservations.store'), [
            'customer_id' => $this->customer->id,
            'room_id' => $this->singleRoom->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 1,
            'status' => 'pending'
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('reservations', ['room_id' => $this->singleRoom->id, 'number_of_guests' => 1]);

        // 2 guests is NOT allowed
        $response = $this->actingAs($this->admin)->post(route('reservations.store'), [
            'customer_id' => $this->customer->id,
            'room_id' => $this->singleRoom->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 2,
            'status' => 'pending'
        ]);

        $response->assertSessionHasErrors(['number_of_guests']);
    }

    public function test_double_room_exceeding_capacity_validation()
    {
        // 2 guests is allowed
        $response = $this->actingAs($this->admin)->post(route('reservations.store'), [
            'customer_id' => $this->customer->id,
            'room_id' => $this->doubleRoom->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 2,
            'status' => 'pending'
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('reservations', ['room_id' => $this->doubleRoom->id, 'number_of_guests' => 2]);

        // 3 guests is NOT allowed
        $response = $this->actingAs($this->admin)->post(route('reservations.store'), [
            'customer_id' => $this->customer->id,
            'room_id' => $this->doubleRoom->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 3,
            'status' => 'pending'
        ]);

        $response->assertSessionHasErrors(['number_of_guests']);
    }

    public function test_deluxe_family_room_exceeding_capacity_validation()
    {
        // 4 guests is allowed
        $response = $this->actingAs($this->admin)->post(route('reservations.store'), [
            'customer_id' => $this->customer->id,
            'room_id' => $this->deluxeFamilyRoom->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 4,
            'status' => 'pending'
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('reservations', ['room_id' => $this->deluxeFamilyRoom->id, 'number_of_guests' => 4]);

        // 5 guests is NOT allowed
        $response = $this->actingAs($this->admin)->post(route('reservations.store'), [
            'customer_id' => $this->customer->id,
            'room_id' => $this->deluxeFamilyRoom->id,
            'check_in_date' => now()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'number_of_guests' => 5,
            'status' => 'pending'
        ]);

        $response->assertSessionHasErrors(['number_of_guests']);
    }
}
