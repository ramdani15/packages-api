<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class OrganzationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get Organizations
     */
    public function test_get_organizations()
    {
        $total = 2;
        for ($i = 0; $i < $total; $i++) {
            Organization::factory()->create();
        }
 
        $response = $this->get('/api/v1/organizations');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => $total
                     ]
                 ]);
    }

    /**
     * Create Organization
     */
    public function test_create_organization()
    {
        $data = [
            'name' => 'new name',
            'description' => 'new description',
        ];
 
        $response = $this->postJson('/api/v1/organizations', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => $data['name'],
                     'description' => $data['description']
                 ]);
    }

    /**
     * Show Organization
     */
    public function test_show_organization()
    {
        $organization = Organization::factory()->create();
        $response = $this->get("/api/v1/organizations/{id}?id={$organization->id}");
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'description' => $organization->description,
                 ]);
    }

    /**
     * Partial Update Organization
     */
    public function test_partial_update_organization()
    {
        $organization = Organization::factory()->create();
        $data = [
            'name' => 'update name'
        ];
        $response = $this->patchJson("/api/v1/organizations/{id}?id={$organization->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $organization->id,
                    'name' => $data['name'],
                    'description' => $organization->description,
                 ]);
    }

    /**
     * Update Organization
     */
    public function test_update_organization()
    {
        $organization = Organization::factory()->create();
        $data = [
            'name' => 'update name',
            'description' => 'update description'
        ];
        $response = $this->putJson("/api/v1/organizations/{id}?id={$organization->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $organization->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                 ]);
    }

    /**
     * Delete Organization
     */
    public function test_delete_organization()
    {
        $organization = Organization::factory()->create();
        $response = $this->deleteJson("/api/v1/organizations/{id}?id={$organization->id}");
        $response->assertStatus(204);
        $organization = Organization::find($organization->id);
        $this->assertNull($organization);
    }
}
