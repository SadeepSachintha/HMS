<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $manager;
    protected $staff;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->manager = User::factory()->create(['role' => 'manager']);
        $this->staff = User::factory()->create(['role' => 'staff']);
    }

    /**
     * Test admin can access activity logs index.
     */
    public function test_admin_can_access_activity_logs()
    {
        $response = $this->actingAs($this->admin)->get(route('activity-logs.index'));

        $response->assertStatus(200);
        $response->assertViewIs('activity-logs.index');
    }

    /**
     * Test manager and staff are forbidden from accessing activity logs.
     */
    public function test_manager_and_staff_cannot_access_activity_logs()
    {
        $response = $this->actingAs($this->manager)->get(route('activity-logs.index'));
        $response->assertStatus(403);

        $response = $this->actingAs($this->staff)->get(route('activity-logs.index'));
        $response->assertStatus(403);
    }

    /**
     * Test model creation automatically triggers an activity log.
     */
    public function test_model_creation_creates_activity_log()
    {
        // Act as admin to perform mutation
        $this->actingAs($this->admin);

        $customer = Customer::create([
            'name' => 'Alice test',
            'email' => 'alice@test.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'created',
            'model_type' => Customer::class,
            'model_id' => $customer->id,
            'user_id' => $this->admin->id,
        ]);
    }

    /**
     * Test model update automatically triggers an activity log.
     */
    public function test_model_update_creates_activity_log()
    {
        $this->actingAs($this->admin);

        $customer = Customer::create([
            'name' => 'Alice test',
            'email' => 'alice@test.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
        ]);

        // Update name
        $customer->update(['name' => 'Alice Updated']);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'updated',
            'model_type' => Customer::class,
            'model_id' => $customer->id,
            'description' => "Updated Customer #{$customer->id} (Fields changed: name)",
            'user_id' => $this->admin->id,
        ]);
    }

    /**
     * Test authentication events trigger logging.
     */
    public function test_login_and_logout_events_trigger_activity_log()
    {
        // 1. Dispatch Login event
        event(new \Illuminate\Auth\Events\Login('web', $this->admin, false));

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'login',
            'user_id' => $this->admin->id,
            'description' => "User {$this->admin->name} logged in successfully.",
        ]);

        // 2. Dispatch Logout event
        event(new \Illuminate\Auth\Events\Logout('web', $this->admin));

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'logout',
            'user_id' => $this->admin->id,
            'description' => "User {$this->admin->name} logged out.",
        ]);
    }

    /**
     * Test admin can export activity logs.
     */
    public function test_admin_can_export_activity_logs()
    {
        $response = $this->actingAs($this->admin)->get(route('activity-logs.export'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * Test manager and staff are forbidden from exporting activity logs.
     */
    public function test_manager_and_staff_cannot_export_activity_logs()
    {
        $response = $this->actingAs($this->manager)->get(route('activity-logs.export'));
        $response->assertStatus(403);

        $response = $this->actingAs($this->staff)->get(route('activity-logs.export'));
        $response->assertStatus(403);
    }
}
