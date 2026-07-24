<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Alert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlertsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Test HTML index request.
     */
    public function test_index_returns_blade_view()
    {
        $response = $this->actingAs($this->user)->get('/alerts');

        $response->assertStatus(200);
        $response->assertViewIs('alerts.index');
    }

    /**
     * Test AJAX index request.
     */
    public function test_index_returns_json_for_ajax()
    {
        // Create 6 alerts
        for ($i = 0; $i < 6; $i++) {
            Alert::create([
                'user_id' => $this->user->id,
                'title' => "Alert $i",
                'message' => "Message $i",
                'type' => 'info',
                'is_read' => false
            ]);
        }

        $response = $this->actingAs($this->user)
                         ->get('/alerts', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)
                 ->assertJsonCount(5); // Should limit to top 5
    }

    /**
     * Test mark alert as read.
     */
    public function test_mark_as_read()
    {
        $alert = Alert::create([
            'user_id' => $this->user->id,
            'title' => 'Test',
            'message' => 'Test message',
            'type' => 'info',
            'is_read' => false
        ]);

        $response = $this->actingAs($this->user)
                         ->post("/alerts/{$alert->id}/mark-as-read");

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertTrue($alert->fresh()->is_read);
    }

    /**
     * Test get unread count.
     */
    public function test_get_unread_count()
    {
        // 3 unread
        for ($i = 0; $i < 3; $i++) {
            Alert::create([
                'user_id' => $this->user->id,
                'title' => "Unread Alert $i",
                'message' => "Message $i",
                'type' => 'info',
                'is_read' => false
            ]);
        }

        // 2 read
        for ($i = 0; $i < 2; $i++) {
            Alert::create([
                'user_id' => $this->user->id,
                'title' => "Read Alert $i",
                'message' => "Message $i",
                'type' => 'info',
                'is_read' => true
            ]);
        }

        $response = $this->actingAs($this->user)->get('/alerts/unread-count');

        $response->assertStatus(200)
                 ->assertJson(['count' => 3]);
    }
}
