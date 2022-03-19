<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SourceTariffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'db' => $this->faker->sentence(),
        ];
    }
}
