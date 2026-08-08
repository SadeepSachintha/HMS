<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_user_index_page_loads()
    {
        $response = $this->actingAs($this->admin)->get('/users');
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    public function test_user_search_filtering()
    {
        $user1 = User::create([
            'name' => 'Alice Searchable',
            'email' => 'alice@example.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        $user2 = User::create([
            'name' => 'Bob Ordinary',
            'email' => 'bob@example.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/users?search=Alice');
        $response->assertStatus(200);
        $response->assertSee('Alice Searchable');
        $response->assertDontSee('Bob Ordinary');
    }

    public function test_user_status_filtering()
    {
        $activeUser = User::create([
            'name' => 'Active Account',
            'email' => 'active@example.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        $inactiveUser = User::create([
            'name' => 'Inactive Account',
            'email' => 'inactive@example.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
            'status' => false,
        ]);

        // Filter active
        $response = $this->actingAs($this->admin)->get('/users?status=active');
        $response->assertStatus(200);
        $response->assertSee('Active Account');
        $response->assertDontSee('Inactive Account');

        // Filter inactive
        $response = $this->actingAs($this->admin)->get('/users?status=inactive');
        $response->assertStatus(200);
        $response->assertSee('Inactive Account');
        $response->assertDontSee('Active Account');
    }
}
