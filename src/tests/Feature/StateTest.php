<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get States
     */
    public function test_get_states()
    {
        $total = 2;
        for ($i = 0; $i < $total; $i++) {
            State::factory()->create();
        }
 
        $response = $this->get('/api/v1/states');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => $total
                     ]
                 ]);
    }

    /**
     * Create State
     */
    public function test_create_state()
    {
        $data = [
            'name' => 'new name',
            'description' => 'new description',
        ];
 
        $response = $this->postJson('/api/v1/states', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => $data['name'],
                     'description' => $data['description']
                 ]);
    }

    /**
     * Show State
     */
    public function test_show_state()
    {
        $state = State::factory()->create();
        $response = $this->get("/api/v1/states/{id}?id={$state->id}");
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $state->id,
                    'name' => $state->name,
                    'description' => $state->description,
                 ]);
    }

    /**
     * Partial Update State
     */
    public function test_partial_update_state()
    {
        $state = State::factory()->create();
        $data = [
            'name' => 'update name'
        ];
        $response = $this->patchJson("/api/v1/states/{id}?id={$state->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $state->id,
                    'name' => $data['name'],
                    'description' => $state->description,
                 ]);
    }

    /**
     * Update State
     */
    public function test_update_state()
    {
        $state = State::factory()->create();
        $data = [
            'name' => 'update name',
            'description' => 'update description'
        ];
        $response = $this->putJson("/api/v1/states/{id}?id={$state->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $state->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                 ]);
    }

    /**
     * Delete State
     */
    public function test_delete_state()
    {
        $state = State::factory()->create();
        $response = $this->deleteJson("/api/v1/states/{id}?id={$state->id}");
        $response->assertStatus(204);
        $state = State::find($state->id);
        $this->assertNull($state);
    }
}
