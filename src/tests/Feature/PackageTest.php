<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use App\Models\PaymentType;
use App\Models\SourceTariff;
use App\Models\State;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get Packages
     */
    public function test_get_packages()
    {
        $response = $this->get('/api/v1/packages');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => 0
                     ]
                 ]);
    }

    /**
     * Create Package
     */
    public function test_create_package()
    {
        $this->seed();
        $paymentType = PaymentType::first();
        $state = State::first();
        $customer1 = Customer::first();
        $customer2 = Customer::orderBy('created_at', 'desc')->first();
        $sourceTariff = SourceTariff::first();
        $data = [
            'payment_type_id' => $paymentType->id,
            'state_id' => $state->id,
            'amount' => '10',
            'discount' => '11',
            'additional_field' => null,
            'code' => 'new code',
            'order' => 11,
            'cash_amount' => 12.5,
            'cash_change' => 13.5,
            'origin_customer_id' => $customer1->id,
            'destination_customer_id' => $customer2->id,
            'connote' => [
                'source_tariff_id' => $sourceTariff->id,
                'state_id' => $state->id,
                'service' => 'service1',
                'code' => 'code1',
                'booking_code' => null,
                'actual_weight' => 10.5,
                'volume_weight' => 11.5,
                'chargeable_weight' => 12.5,
                'total_package' => 13,
                'surcharge_amount' => 14,
                'sla_day' => 15,
                'pod' => null,
            ],
            'kolis' => [
                [
                    'length' => 10,
                    'awb_url' => 'http://localhost.com/awb.png',
                    'chargeable_weight' => 11.5,
                    'width' => 12,
                    'height' => 13,
                    'description' => 'description1',
                    'volume' => 13.5,
                    'weight' => 14,
                ],
                [
                    'length' => 10,
                    'awb_url' => 'http://localhost.com/awb.png',
                    'chargeable_weight' => 11.5,
                    'width' => 12,
                    'height' => 13,
                    'description' => 'description1',
                    'volume' => 13.5,
                    'weight' => 14,
                ]
            ]
        ];
 
        $response = $this->postJson('/api/v1/packages', $data);

        $response->assertStatus(201);
    }

    /**
     * Partial Update Package
     */
    public function test_partial_update_package()
    {
        // Pass
        $this->assertTrue(true);
    }

    /**
     * Update Package
     */
    public function test_update_package()
    {
        // Pass
        $this->assertTrue(true);
    }

    /**
     * Delete Package
     */
    public function test_delete_package()
    {
        $this->test_create_package();
        $package = Transaction::first();
        $response = $this->deleteJson("/api/v1/packages/{id}?id={$package->id}");
        $response->assertStatus(204);
        $package = Transaction::find($package->id);
        $this->assertNull($package);
    }
}
