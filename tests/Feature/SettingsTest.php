<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed default setting
        Setting::create([
            'hotel_name' => 'Test Hotel',
            'contact_email' => 'test@hotel.com',
            'contact_phone' => '1234567890',
            'check_in_time' => '14:00:00',
            'check_out_time' => '12:00:00',
            'service_charge_rate' => 10.00,
            'sscl_rate' => 2.50,
            'tdl_rate' => 1.00,
            'vat_rate' => 18.00,
        ]);
    }

    public function test_admin_can_update_settings_and_tax_rates()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('settings.update'), [
            'hotel_name' => 'Updated Grand Palace',
            'contact_email' => 'grand@palace.com',
            'contact_phone' => '987654321',
            'check_in_time' => '15:00',
            'check_out_time' => '11:00',
            'service_charge_rate' => 8.00,
            'sscl_rate' => 3.00,
            'tdl_rate' => 1.50,
            'vat_rate' => 15.00,
        ]);

        $response->assertRedirect(route('settings.index'));
        
        $setting = Setting::first();
        $this->assertEquals('Updated Grand Palace', $setting->hotel_name);
        $this->assertEquals(8.00, $setting->service_charge_rate);
        $this->assertEquals(3.00, $setting->sscl_rate);
        $this->assertEquals(1.50, $setting->tdl_rate);
        $this->assertEquals(15.00, $setting->vat_rate);
    }

    public function test_invoice_creation_calculates_correct_taxes_based_on_settings()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        // Update settings rates
        $this->actingAs($admin)->post(route('settings.update'), [
            'hotel_name' => 'Updated Grand Palace',
            'contact_email' => 'grand@palace.com',
            'contact_phone' => '987654321',
            'check_in_time' => '15:00',
            'check_out_time' => '11:00',
            'service_charge_rate' => 12.00, // 12%
            'sscl_rate' => 4.00,           // 4%
            'tdl_rate' => 2.00,           // 2%
            'vat_rate' => 10.00,          // 10%
        ]);

        // Manually create an invoice via InvoiceController@store
        $response = $this->actingAs($admin)->post(route('invoices.store'), [
            'customer_id' => $customer->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
            'subtotal' => 1000.00,
            'tax_rate' => 28.00, // Sum of 12+4+2+10
            'tax_amount' => 280.00,
            'total_amount' => 1280.00,
        ]);

        $invoice = Invoice::latest()->first();
        $this->assertNotNull($invoice);
        
        // Assert calculations
        // subtotal = 1000.00
        // service_charge = 1000.00 * 12% = 120.00
        // sscl_amount = 1000.00 * 4% = 40.00
        // tdl_amount = 1000.00 * 2% = 20.00
        // vat_amount = 1000.00 * 10% = 100.00
        // grand_total = 1000 + 120 + 40 + 20 + 100 = 1280.00
        $this->assertEquals(1000.00, $invoice->base_amount);
        $this->assertEquals(120.00, $invoice->service_charge);
        $this->assertEquals(40.00, $invoice->sscl_amount);
        $this->assertEquals(20.00, $invoice->tdl_amount);
        $this->assertEquals(100.00, $invoice->vat_amount);
        $this->assertEquals(1280.00, $invoice->grand_total);
    }
}
