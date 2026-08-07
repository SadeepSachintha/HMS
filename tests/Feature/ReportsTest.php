<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\FoodItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsTest extends TestCase
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

    /** @test */
    public function admin_and_manager_can_access_reports_index_page()
    {
        $response = $this->actingAs($this->admin)->get(route('reports.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->manager)->get(route('reports.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function staff_cannot_access_reports_index_page()
    {
        $response = $this->actingAs($this->staff)->get(route('reports.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_fetch_food_sales_report_data()
    {
        // Seed a food item
        $food = FoodItem::create([
            'name' => 'Burger Combo',
            'description' => 'Burger and drink',
            'category' => 'Main',
            'price' => 1200.00,
            'is_available' => true
        ]);

        // Seed an invoice with a food item line
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@mail.com',
            'phone' => '+94763928334',
            'nic_passport' => '123456789V',
            'address' => 'Moratuwa',
            'city' => 'Moratuwa',
            'state' => 'Colombo',
            'postal_code' => '10400',
            'country' => 'Sri Lanka'
        ]);
        $invoice = Invoice::create([
            'invoice_number' => 'INV-000001',
            'customer_id' => $customer->id,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'subtotal' => 1200.00,
            'tax_rate' => 31.50,
            'tax_amount' => 378.00,
            'total_amount' => 1578.00,
            'status' => 'sent',
            'base_amount' => 1200.00,
            'service_charge' => 120.00,
            'sscl_amount' => 30.00,
            'tdl_amount' => 12.00,
            'vat_amount' => 216.00,
            'grand_total' => 1578.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'description' => 'Burger Combo',
            'quantity' => 2,
            'unit_price' => 1200.00
        ]);

        $response = $this->actingAs($this->admin)->postJson(route('reports.fetch-data'), [
            'report_type' => 'food_sales',
            'from_date' => now()->subDays(1)->toDateString(),
            'to_date' => now()->addDays(1)->toDateString(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.total', 2400);
        $response->assertJsonFragment([
            'food_item_name' => 'Burger Combo',
            'unit_price' => 1200,
            'quantity_sold' => 2,
            'total_sales' => 2400
        ]);
    }

    /** @test */
    public function admin_can_fetch_tax_levies_report_data()
    {
        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@mail.com',
            'phone' => '+94763928335',
            'nic_passport' => '987654321V',
            'address' => 'Colombo',
            'city' => 'Colombo',
            'state' => 'Colombo',
            'postal_code' => '00100',
            'country' => 'Sri Lanka'
        ]);
        Invoice::create([
            'invoice_number' => 'INV-000001',
            'customer_id' => $customer->id,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'subtotal' => 1000.00,
            'tax_rate' => 31.50,
            'tax_amount' => 315.00,
            'total_amount' => 1315.00,
            'status' => 'sent',
            'base_amount' => 1000.00,
            'service_charge' => 100.00,
            'sscl_amount' => 25.00,
            'tdl_amount' => 10.00,
            'vat_amount' => 180.00,
            'grand_total' => 1315.00,
        ]);

        $response = $this->actingAs($this->admin)->postJson(route('reports.fetch-data'), [
            'report_type' => 'tax_levies',
            'from_date' => now()->subDays(1)->toDateString(),
            'to_date' => now()->addDays(1)->toDateString(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.totals.grand_total', 1315);
        $response->assertJsonFragment([
            'invoice_number' => 'INV-000001',
            'base_amount' => 1000,
            'service_charge' => 100,
            'sscl_amount' => 25,
            'tdl_amount' => 10,
            'vat_amount' => 180,
            'grand_total' => 1315,
        ]);
    }

    /** @test */
    public function admin_can_export_pdf_reports()
    {
        $response = $this->actingAs($this->admin)->post(route('reports.export-pdf'), [
            'report_type' => 'food_sales',
            'from_date' => now()->subDays(1)->toDateString(),
            'to_date' => now()->addDays(1)->toDateString(),
        ]);
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        $response = $this->actingAs($this->admin)->post(route('reports.export-pdf'), [
            'report_type' => 'tax_levies',
            'from_date' => now()->subDays(1)->toDateString(),
            'to_date' => now()->addDays(1)->toDateString(),
        ]);
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function admin_can_export_excel_reports()
    {
        $response = $this->actingAs($this->admin)->get(route('reports.export-excel', [
            'report_type' => 'food_sales',
            'from_date' => now()->subDays(1)->toDateString(),
            'to_date' => now()->addDays(1)->toDateString(),
        ]));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $response = $this->actingAs($this->admin)->get(route('reports.export-excel', [
            'report_type' => 'tax_levies',
            'from_date' => now()->subDays(1)->toDateString(),
            'to_date' => now()->addDays(1)->toDateString(),
        ]));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function guest_cannot_see_pay_or_record_payment_buttons()
    {
        $customer = Customer::create([
            'name' => 'Jane Doe',
            'email' => 'jane@mail.com',
            'phone' => '+94763928335',
            'nic_passport' => '987654321V',
            'address' => 'Colombo',
            'city' => 'Colombo',
            'state' => 'Colombo',
            'postal_code' => '00100',
            'country' => 'Sri Lanka'
        ]);
        $invoice = Invoice::create([
            'invoice_number' => 'INV-000002',
            'customer_id' => $customer->id,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'subtotal' => 1000.00,
            'tax_rate' => 31.50,
            'tax_amount' => 315.00,
            'total_amount' => 1315.00,
            'status' => 'sent',
            'base_amount' => 1000.00,
            'service_charge' => 100.00,
            'sscl_amount' => 25.00,
            'tdl_amount' => 10.00,
            'vat_amount' => 180.00,
            'grand_total' => 1315.00,
        ]);

        $adminUser = User::factory()->create(['role' => 'admin']);
        $guestUser = User::factory()->create(['role' => 'guest']);

        // Admin views invoice index
        $response = $this->actingAs($adminUser)->get(route('invoices.index'));
        $response->assertSee('payments/create');

        // Admin views invoice show
        $response = $this->actingAs($adminUser)->get(route('invoices.show', $invoice));
        $response->assertSee('Record Payment');
        $response->assertSee('payments/create');

        // Guest views invoice index
        $response = $this->actingAs($guestUser)->get(route('invoices.index'));
        $response->assertDontSee('payments/create');

        // Guest views invoice show
        $response = $this->actingAs($guestUser)->get(route('invoices.show', $invoice));
        $response->assertDontSee('Record Payment');
        $response->assertDontSee('payments/create');
    }
}
