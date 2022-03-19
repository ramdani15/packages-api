<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Location;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get Locations
     */
    public function test_get_locations()
    {
        $total = 2;
        for ($i = 0; $i < $total; $i++) {
            Location::factory()->create();
        }
 
        $response = $this->get('/api/v1/locations');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => $total
                     ]
                 ]);
    }

    /**
     * Create Location
     */
    public function test_create_location()
    {
        $data = [
            'name' => 'new name',
            'zip_code' => 'new zip_code',
            'zone_code' => 'new zone_code',
        ];
 
        $response = $this->postJson('/api/v1/locations', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => $data['name'],
                     'zip_code' => $data['zip_code'],
                     'zone_code' => $data['zone_code'],
                 ]);
    }

    /**
     * Show Location
     */
    public function test_show_location()
    {
        $location = Location::factory()->create();
        $response = $this->get("/api/v1/locations/{id}?id={$location->id}");
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $location->id,
                    'name' => $location->name,
                    'zip_code' => $location->zip_code,
                    'zone_code' => $location->zone_code,
                 ]);
    }

    /**
     * Partial Update Location
     */
    public function test_partial_update_location()
    {
        $location = Location::factory()->create();
        $data = [
            'zip_code' => 'update zip_code'
        ];
        $response = $this->patchJson("/api/v1/locations/{id}?id={$location->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $location->id,
                    'name' => $location->name,
                    'zip_code' => $data['zip_code'],
                    'zone_code' => $location->zone_code,
                 ]);
    }

    /**
     * Update Location
     */
    public function test_update_location()
    {
        $location = Location::factory()->create();
        $data = [
            'name' => 'update name',
            'zip_code' => 'update zip_code',
            'zone_code' => 'update zone_code'
        ];
        $response = $this->putJson("/api/v1/locations/{id}?id={$location->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $location->id,
                    'name' => $data['name'],
                    'zip_code' => $data['zip_code'],
                    'zone_code' => $data['zone_code'],
                 ]);
    }

    /**
     * Delete Location
     */
    public function test_delete_location()
    {
        $location = Location::factory()->create();
        $response = $this->deleteJson("/api/v1/locations/{id}?id={$location->id}");
        $response->assertStatus(204);
        $location = Location::find($location->id);
        $this->assertNull($location);
    }
}
