<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Formula;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FormulaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get Formulas
     */
    public function test_get_formulas()
    {
        $total = 2;
        for ($i = 0; $i < $total; $i++) {
            Formula::factory()->create();
        }
 
        $response = $this->get('/api/v1/formulas');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => $total
                     ]
                 ]);
    }

    /**
     * Create Formula
     */
    public function test_create_formula()
    {
        $data = [
            'name' => 'new name',
            'description' => 'new description',
        ];
 
        $response = $this->postJson('/api/v1/formulas', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => $data['name'],
                     'description' => $data['description']
                 ]);
    }

    /**
     * Show Formula
     */
    public function test_show_formula()
    {
        $formula = Formula::factory()->create();
        $response = $this->get("/api/v1/formulas/{id}?id={$formula->id}");
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $formula->id,
                    'name' => $formula->name,
                    'description' => $formula->description,
                 ]);
    }

    /**
     * Partial Update Formula
     */
    public function test_partial_update_formula()
    {
        $formula = Formula::factory()->create();
        $data = [
            'name' => 'update name'
        ];
        $response = $this->patchJson("/api/v1/formulas/{id}?id={$formula->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $formula->id,
                    'name' => $data['name'],
                    'description' => $formula->description,
                 ]);
    }

    /**
     * Update Formula
     */
    public function test_update_formula()
    {
        $formula = Formula::factory()->create();
        $data = [
            'name' => 'update name',
            'description' => 'update description'
        ];
        $response = $this->putJson("/api/v1/formulas/{id}?id={$formula->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $formula->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                 ]);
    }

    /**
     * Delete Formula
     */
    public function test_delete_formula()
    {
        $formula = Formula::factory()->create();
        $response = $this->deleteJson("/api/v1/formulas/{id}?id={$formula->id}");
        $response->assertStatus(204);
        $formula = Formula::find($formula->id);
        $this->assertNull($formula);
    }
}
