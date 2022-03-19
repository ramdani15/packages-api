<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location_id' => Location::factory(),
            'organization_id' => Organization::factory(),
            'name' => $this->faker->sentence(),
            'code' => Str::random(5),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'nama_sales' => $this->faker->name(),
            'top' => Str::random(3),
            'jenis_pelanggan' => Str::random(3)
        ];
    }
}
