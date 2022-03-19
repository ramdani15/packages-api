<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get Customers
     */
    public function test_get_customers()
    {
        $total = 2;
        for ($i = 0; $i < $total; $i++) {
            Customer::factory()->create();
        }
 
        $response = $this->get('/api/v1/customers');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => $total
                     ]
                 ]);
    }

    /**
     * Create Customer
     */
    public function test_create_customer()
    {
        $location = Location::factory()->create();
        $organization = Organization::factory()->create();
        $data = [
            'location_id' => $location->id,
            'organization_id' => $organization->id,
            'name' => 'new name',
            'code' => 'new code',
            'address' => 'new address',
            'address_detail' => 'new address_detail',
            'email' => 'newemail@mail.com',
            'phone' => '+1231231',
            'nama_sales' => 'new nama_sales',
            'top' => 'new top',
            'jenis_pelanggan' => 'new jenis_pelanggan',
        ];
 
        $response = $this->postJson('/api/v1/customers', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'location_id' => $data['location_id'],
                     'organization_id' => $data['organization_id'],
                     'name' => $data['name'],
                     'code' => $data['code'],
                     'address' => $data['address'],
                     'address_detail' => $data['address_detail'],
                     'email' => $data['email'],
                     'phone' => $data['phone'],
                     'nama_sales' => $data['nama_sales'],
                     'top' => $data['top'],
                     'jenis_pelanggan' => $data['jenis_pelanggan'],
                 ]);
    }

    /**
     * Show Customer
     */
    public function test_show_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->get("/api/v1/customers/{id}?id={$customer->id}");
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $customer->id,
                    'location_id' => $customer->location_id,
                     'organization_id' => $customer->organization_id,
                     'name' => $customer->name,
                     'code' => $customer->code,
                     'address' => $customer->address,
                     'address_detail' => $customer->address_detail,
                     'email' => $customer->email,
                     'phone' => $customer->phone,
                     'nama_sales' => $customer->nama_sales,
                     'top' => $customer->top,
                     'jenis_pelanggan' => $customer->jenis_pelanggan,
                 ]);
    }

    /**
     * Partial Update Customer
     */
    public function test_partial_update_customer()
    {
        $customer = Customer::factory()->create();
        $data = [
            'name' => 'update name'
        ];
        $response = $this->patchJson("/api/v1/customers/{id}?id={$customer->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $customer->id,
                    'name' => $data['name'],
                    'code' => $customer->code,
                 ]);
    }

    /**
     * Update Customer
     */
    public function test_update_customer()
    {
        $customer = Customer::factory()->create();
        $location = Location::factory()->create();
        $organization = Organization::factory()->create();
        $data = [
            'location_id' => $location->id,
            'organization_id' => $organization->id,
            'name' => 'new name',
            'code' => 'new code',
            'address' => 'new address',
            'address_detail' => 'new address_detail',
            'email' => 'newemail@mail.com',
            'phone' => '+1231231',
            'nama_sales' => 'new nama_sales',
            'top' => 'new top',
            'jenis_pelanggan' => 'new jenis_pelanggan',
        ];
        $response = $this->putJson("/api/v1/customers/{id}?id={$customer->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $customer->id,
                    'location_id' => $data['location_id'],
                    'organization_id' => $data['organization_id'],
                    'name' => $data['name'],
                    'code' => $data['code'],
                    'address' => $data['address'],
                    'address_detail' => $data['address_detail'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'nama_sales' => $data['nama_sales'],
                    'top' => $data['top'],
                    'jenis_pelanggan' => $data['jenis_pelanggan'],
                 ]);
    }

    /**
     * Delete Customer
     */
    public function test_delete_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->deleteJson("/api/v1/customers/{id}?id={$customer->id}");
        $response->assertStatus(204);
        $customer = Customer::find($customer->id);
        $this->assertNull($customer);
    }
}
