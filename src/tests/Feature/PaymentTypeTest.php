<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PaymentType;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PaymentTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get PaymentTypes
     */
    public function test_getpayment_types()
    {
        $total = 2;
        for ($i = 0; $i < $total; $i++) {
            PaymentType::factory()->create();
        }
 
        $response = $this->get('/api/v1/payment-types');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => $total
                     ]
                 ]);
    }

    /**
     * Create PaymentType
     */
    public function test_createpayment_type()
    {
        $data = [
            'name' => 'new name',
            'description' => 'new description',
        ];
 
        $response = $this->postJson('/api/v1/payment-types', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => $data['name'],
                     'description' => $data['description']
                 ]);
    }

    /**
     * Show PaymentType
     */
    public function test_showpayment_type()
    {
        $paymentType = PaymentType::factory()->create();
        $response = $this->get("/api/v1/payment-types/{id}?id={$paymentType->id}");
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $paymentType->id,
                    'name' => $paymentType->name,
                    'description' => $paymentType->description,
                 ]);
    }

    /**
     * Partial Update PaymentType
     */
    public function test_partial_updatepayment_type()
    {
        $paymentType = PaymentType::factory()->create();
        $data = [
            'name' => 'update name'
        ];
        $response = $this->patchJson("/api/v1/payment-types/{id}?id={$paymentType->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $paymentType->id,
                    'name' => $data['name'],
                    'description' => $paymentType->description,
                 ]);
    }

    /**
     * Update PaymentType
     */
    public function test_updatepayment_type()
    {
        $paymentType = PaymentType::factory()->create();
        $data = [
            'name' => 'update name',
            'description' => 'update description'
        ];
        $response = $this->putJson("/api/v1/payment-types/{id}?id={$paymentType->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $paymentType->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                 ]);
    }

    /**
     * Delete PaymentType
     */
    public function test_deletepayment_type()
    {
        $paymentType = PaymentType::factory()->create();
        $response = $this->deleteJson("/api/v1/payment-types/{id}?id={$paymentType->id}");
        $response->assertStatus(204);
        $paymentType = PaymentType::find($paymentType->id);
        $this->assertNull($paymentType);
    }
}
