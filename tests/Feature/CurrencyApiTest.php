<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyApiTest extends TestCase
{
    /**
     * Test successful conversion.
     *
     * @return void
     */
    public function test_successful_conversion()
    {
        $response = $this->getJson('/api/convert?base=USD&target=LKR&amount=100');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'base',
                     'target',
                     'amount',
                     'converted_amount',
                     'rate',
                     'cached'
                 ])
                 ->assertJson([
                     'base' => 'USD',
                     'target' => 'LKR',
                     'amount' => 100,
                     'rate' => 300.0,
                     'converted_amount' => 30000.0
                 ]);
    }

    /**
     * Test unsupported currency.
     *
     * @return void
     */
    public function test_unsupported_currency()
    {
        $response = $this->getJson('/api/convert?base=USD&target=XYZ&amount=100');

        $response->assertStatus(400)
                 ->assertJson([
                     'detail' => 'Unsupported currency code'
                 ]);
    }

    /**
     * Test validation constraints.
     *
     * @return void
     */
    public function test_validation_constraints()
    {
        $response = $this->getJson('/api/convert?base=U&target=LKR&amount=100');
        $response->assertStatus(422);

        $response = $this->getJson('/api/convert?base=USD&target=LKR&amount=-1');
        $response->assertStatus(422);
    }
}
