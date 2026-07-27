<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Staff;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffNicTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin'
        ]);
    }

    /**
     * Test staff creation with nic.
     */
    public function test_staff_can_be_created_with_nic()
    {
        $response = $this->actingAs($this->adminUser)
            ->post('/staff', [
                'name' => 'John Doe',
                'email' => 'john.doe@hotel.com',
                'phone' => '+1234567890',
                'nic' => '911042754V',
                'position' => 'Manager',
                'department' => 'Front Office',
                'hire_date' => '2023-01-15',
                'address' => '123 Main St',
                'status' => 'active',
                'role' => 'staff'
            ]);

        $response->assertRedirect('/staff');
        $this->assertDatabaseHas('staff', [
            'name' => 'John Doe',
            'nic' => '911042754V'
        ]);
    }

    /**
     * Test staff nic uniqueness validation.
     */
    public function test_staff_nic_must_be_unique()
    {
        // First staff
        Staff::create([
            'user_id' => $this->adminUser->id,
            'name' => 'John Doe',
            'email' => 'john@hotel.com',
            'phone' => '+1234567890',
            'nic' => '911042754V',
            'position' => 'Manager',
            'department' => 'Front Office',
            'hire_date' => '2023-01-15',
            'address' => '123 Main St',
            'status' => 'active'
        ]);

        // Second staff with same nic should fail
        $response = $this->actingAs($this->adminUser)
            ->post('/staff', [
                'name' => 'Jane Smith',
                'email' => 'jane@hotel.com',
                'phone' => '+9876543210',
                'nic' => '911042754V',
                'position' => 'Supervisor',
                'department' => 'Housekeeping',
                'hire_date' => '2023-01-15',
                'address' => '123 Main St',
                'status' => 'active',
                'role' => 'staff'
            ]);

        $response->assertSessionHasErrors('nic');
    }

    /**
     * Test guest self-registration forms with phone & nic.
     */
    public function test_guest_can_register_with_phone_and_nic()
    {
        $response = $this->post('/register', [
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '+94771234567',
            'nic_passport' => '199529835679'
        ]);

        $response->assertRedirect('/reservations');
        $this->assertDatabaseHas('users', [
            'email' => 'guest@example.com',
            'role' => 'guest'
        ]);

        $this->assertDatabaseHas('customers', [
            'email' => 'guest@example.com',
            'phone' => '+94771234567',
            'nic_passport' => '199529835679'
        ]);
    }
}
