<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImmutableInvoicePaymentTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $invoice;
    private $payment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $customer = Customer::create([
            'name' => 'Jane Smith',
            'email' => 'jane@smith.com',
            'phone' => '1234567890',
            'address' => '123 Pine St'
        ]);

        $this->invoice = Invoice::create([
            'invoice_number' => 'INV-2026-9999',
            'customer_id' => $customer->id,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(5)->toDateString(),
            'subtotal' => 100.00,
            'tax_rate' => 31.50,
            'tax_amount' => 31.50,
            'total_amount' => 131.50,
            'status' => 'sent'
        ]);

        $this->payment = Payment::create([
            'invoice_id' => $this->invoice->id,
            'amount' => 131.50,
            'payment_method' => 'cash',
            'payment_date' => now(),
            'status' => 'completed'
        ]);
    }

    public function test_invoice_edit_and_update_are_forbidden()
    {
        $response = $this->actingAs($this->admin)->get(route('invoices.show', $this->invoice));
        $response->assertStatus(200);

        // Edit route is unregistered and yields 404
        $response = $this->actingAs($this->admin)->get("/invoices/{$this->invoice->id}/edit");
        $response->assertStatus(404);

        // PUT request on base resource route yields 405 Method Not Allowed since UPDATE is unregistered
        $response = $this->actingAs($this->admin)->put("/invoices/{$this->invoice->id}", [
            'customer_id' => $this->invoice->customer_id,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(5)->toDateString(),
            'subtotal' => 100.00,
            'tax_rate' => 31.50,
            'tax_amount' => 31.50,
            'total_amount' => 131.50,
            'status' => 'paid'
        ]);
        $response->assertStatus(405);
    }

    public function test_payment_edit_and_update_are_forbidden()
    {
        $response = $this->actingAs($this->admin)->get(route('payments.show', $this->payment));
        $response->assertStatus(200);

        // Edit route is unregistered and yields 404
        $response = $this->actingAs($this->admin)->get("/payments/{$this->payment->id}/edit");
        $response->assertStatus(404);

        // PUT request on base resource route yields 405 Method Not Allowed since UPDATE is unregistered
        $response = $this->actingAs($this->admin)->put("/payments/{$this->payment->id}", [
            'invoice_id' => $this->invoice->id,
            'amount' => 131.50,
            'payment_method' => 'credit_card',
            'payment_date' => now(),
            'status' => 'refunded'
        ]);
        $response->assertStatus(405);
    }
}
