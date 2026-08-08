<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Staff;
use App\Models\User;

class StaffManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user for testing
        $this->user = User::factory()->admin()->create();
    }

    public function test_staff_index_page_loads()
    {
        $response = $this->actingAs($this->user)->get('/staff');

        $response->assertStatus(200);
        $response->assertViewIs('staff.index');
    }

    public function test_staff_create_page_loads()
    {
        $response = $this->actingAs($this->user)->get('/staff/create');

        $response->assertStatus(200);
        $response->assertViewIs('staff.create');
    }

    public function test_can_create_staff_member()
    {
        $staffData = [
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'phone' => '+1-555-0101',
            'position' => 'Front Desk Manager',
            'department' => 'Front Office',
            'address' => '123 Main St, City, State 12345',
            'hire_date' => '2023-01-15',
            'status' => 'active',
            'salary' => 45000.00,
            'emergency_contact' => 'Jane Doe (Wife) - +1-555-0102',
            'role' => 'staff',
        ];

        $response = $this->actingAs($this->user)->post('/staff', $staffData);

        $response->assertRedirect('/staff');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('staff', [
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'position' => 'Front Desk Manager',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'role' => 'staff',
        ]);

        $staff = Staff::where('email', 'john.doe@hotel.com')->first();
        $user = User::where('email', 'john.doe@hotel.com')->first();
        $this->assertEquals($user->id, $staff->user_id);
    }

    public function test_can_update_staff_member()
    {
        $staff = Staff::create([
            'user_id' => $this->user->id,
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'phone' => '+1-555-0101',
            'position' => 'Front Desk Manager',
            'department' => 'Front Office',
            'address' => '123 Main St',
            'hire_date' => '2023-01-15',
            'status' => 'active',
        ]);

        $updateData = [
            'name' => 'John Smith',
            'email' => 'john.smith@hotel.com',
            'phone' => '+1-555-0102',
            'position' => 'Senior Front Desk Manager',
            'department' => 'Front Office',
            'address' => '456 Oak Ave',
            'hire_date' => '2023-01-15',
            'status' => 'active',
            'role' => 'staff',
        ];

        $response = $this->actingAs($this->user)->put("/staff/{$staff->id}", $updateData);

        $response->assertRedirect('/staff');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'name' => 'John Smith',
            'email' => 'john.smith@hotel.com',
            'position' => 'Senior Front Desk Manager',
        ]);
    }

    public function test_cannot_delete_staff_member()
    {
        $staff = Staff::create([
            'user_id' => $this->user->id,
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'phone' => '+1-555-0101',
            'position' => 'Front Desk Manager',
            'department' => 'Front Office',
            'address' => '123 Main St',
            'hire_date' => '2023-01-15',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->delete("/staff/{$staff->id}");

        $response->assertStatus(405);
        $this->assertDatabaseHas('staff', ['id' => $staff->id]);
    }

    public function test_staff_search_functionality()
    {
        Staff::create([
            'user_id' => $this->user->id,
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'phone' => '+1-555-0101',
            'position' => 'Front Desk Manager',
            'department' => 'Front Office',
            'address' => '123 Main St',
            'hire_date' => '2023-01-15',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->get('/staff?search=John');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
    }

    public function test_staff_status_filter()
    {
        Staff::create([
            'user_id' => $this->user->id,
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'phone' => '+1-555-0101',
            'position' => 'Front Desk Manager',
            'department' => 'Front Office',
            'address' => '123 Main St',
            'hire_date' => '2023-01-15',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->get('/staff?status=active');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
    }

    public function test_staff_validation_errors()
    {
        $response = $this->actingAs($this->user)->post('/staff', []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'position', 'department', 'hire_date', 'address', 'status']);
    }

    public function test_staff_email_uniqueness()
    {
        Staff::create([
            'user_id' => $this->user->id,
            'name' => 'John Doe',
            'email' => 'john.doe@hotel.com',
            'phone' => '+1-555-0101',
            'position' => 'Front Desk Manager',
            'department' => 'Front Office',
            'address' => '123 Main St',
            'hire_date' => '2023-01-15',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)->post('/staff', [
            'name' => 'Jane Doe',
            'email' => 'john.doe@hotel.com', // Same email
            'phone' => '+1-555-0102',
            'position' => 'Housekeeping',
            'department' => 'Housekeeping',
            'address' => '456 Oak Ave',
            'hire_date' => '2023-02-15',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_staff_status_syncs_to_user_status()
    {
        $staff = Staff::create([
            'user_id' => $this->user->id,
            'name' => 'Sync Test',
            'email' => 'sync.test@hotel.com',
            'phone' => '+1-555-9999',
            'position' => 'Clerk',
            'department' => 'Front Office',
            'address' => '789 Road',
            'hire_date' => '2023-01-15',
            'status' => 'active',
        ]);

        $user = $staff->user;
        $this->assertTrue($user->status);

        // Update staff status to inactive
        $this->actingAs($this->user)->put("/staff/{$staff->id}", [
            'name' => 'Sync Test',
            'email' => 'sync.test@hotel.com',
            'phone' => '+1-555-9999',
            'position' => 'Clerk',
            'department' => 'Front Office',
            'address' => '789 Road',
            'hire_date' => '2023-01-15',
            'status' => 'inactive',
        ]);

        $user->refresh();
        $this->assertFalse($user->status);
    }

    public function test_user_status_syncs_to_staff_status()
    {
        $staff = Staff::create([
            'user_id' => $this->user->id,
            'name' => 'Sync Test 2',
            'email' => 'sync.test2@hotel.com',
            'phone' => '+1-555-9998',
            'position' => 'Clerk',
            'department' => 'Front Office',
            'address' => '789 Road',
            'hire_date' => '2023-01-15',
            'status' => 'active',
        ]);

        $user = $staff->user;

        // Toggle user status to inactive
        $this->actingAs($this->user)->post("/users/{$user->id}/toggle-status");

        $staff->refresh();
        $this->assertEquals('inactive', $staff->status);

        // Toggle back to active
        $this->actingAs($this->user)->post("/users/{$user->id}/toggle-status");

        $staff->refresh();
        $this->assertEquals('active', $staff->status);
    }
}
