<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
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
     * Test a customer can be created with nic_passport.
     */
    public function test_customer_can_be_created_with_nic_passport()
    {
        $response = $this->actingAs($this->adminUser)
            ->post('/customers', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'nic_passport' => 'NIC123456',
                'address' => '123 Main St',
                'city' => 'Colombo',
                'state' => 'Western',
                'postal_code' => '00100',
                'country' => 'Sri Lanka',
                'loyalty_points' => 10,
                'notes' => 'Vip Guest'
            ]);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'nic_passport' => 'NIC123456'
        ]);
    }

    /**
     * Test validation rule for nic_passport length.
     */
    public function test_nic_passport_max_length_validation()
    {
        $longNic = str_repeat('A', 51);

        $response = $this->actingAs($this->adminUser)
            ->post('/customers', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'nic_passport' => $longNic
            ]);

        $response->assertSessionHasErrors('nic_passport');
    }

    /**
     * Test customer can be updated with new nic_passport.
     */
    public function test_customer_can_be_updated()
    {
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'nic_passport' => 'NIC123'
        ]);

        $response = $this->actingAs($this->adminUser)
            ->put("/customers/{$customer->id}", [
                'name' => 'John Updated',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'nic_passport' => 'PASSPORT456'
            ]);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'John Updated',
            'nic_passport' => 'PASSPORT456'
        ]);
    }

    /**
     * Test searching by nic_passport.
     */
    public function test_searching_by_nic_passport()
    {
        $c1 = Customer::create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'phone' => '+1111111111',
            'nic_passport' => 'SL-NIC-999'
        ]);

        $c2 = Customer::create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'phone' => '+2222222222',
            'nic_passport' => 'US-PASS-111'
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get('/customers?search=SL-NIC-999');

        $response->assertStatus(200);
        $response->assertSee('Alice');
        $response->assertDontSee('Bob');
    }
}
