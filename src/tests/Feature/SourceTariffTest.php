<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SourceTariff;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SourceTariffTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get SourceTariffs
     */
    public function test_get_soure_tariffs()
    {
        $total = 2;
        for ($i = 0; $i < $total; $i++) {
            SourceTariff::factory()->create();
        }
 
        $response = $this->get('/api/v1/source-tariffs');

        $response->assertStatus(200)
                 ->assertJson([
                     'pagination' => [
                         'total' => $total
                     ]
                 ]);
    }

    /**
     * Create SourceTariff
     */
    public function test_create_soure_tariff()
    {
        $data = [
            'db' => 'new db',
        ];
 
        $response = $this->postJson('/api/v1/source-tariffs', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'db' => $data['db'],
                 ]);
    }

    /**
     * Show SourceTariff
     */
    public function test_show_soure_tariff()
    {
        $sourceTariff = SourceTariff::factory()->create();
        $response = $this->get("/api/v1/source-tariffs/{id}?id={$sourceTariff->id}");
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $sourceTariff->id,
                    'db' => $sourceTariff->db,
                 ]);
    }

    /**
     * Partial Update SourceTariff
     */
    public function test_partial_update_soure_tariff()
    {
        $sourceTariff = SourceTariff::factory()->create();
        $data = [
            'db' => 'update db'
        ];
        $response = $this->patchJson("/api/v1/source-tariffs/{id}?id={$sourceTariff->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $sourceTariff->id,
                    'db' => $data['db'],
                 ]);
    }

    /**
     * Update SourceTariff
     */
    public function test_update_soure_tariff()
    {
        $sourceTariff = SourceTariff::factory()->create();
        $data = [
            'db' => 'update db',
        ];
        $response = $this->putJson("/api/v1/source-tariffs/{id}?id={$sourceTariff->id}", $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $sourceTariff->id,
                    'db' => $data['db'],
                 ]);
    }

    /**
     * Delete SourceTariff
     */
    public function test_delete_soure_tariff()
    {
        $sourceTariff = SourceTariff::factory()->create();
        $response = $this->deleteJson("/api/v1/source-tariffs/{id}?id={$sourceTariff->id}");
        $response->assertStatus(204);
        $sourceTariff = SourceTariff::find($sourceTariff->id);
        $this->assertNull($sourceTariff);
    }
}
