<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Customer::factory(2)->create();
        \App\Models\Formula::factory(2)->create();
        \App\Models\Location::factory(2)->create();
        \App\Models\Organization::factory(2)->create();
        \App\Models\PaymentType::factory(2)->create();
        \App\Models\SourceTariff::factory(2)->create();
        \App\Models\State::factory(2)->create();
    }
}
