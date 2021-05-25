<?php

namespace Database\Seeders;

use App\Models\HealthCondition;
use Illuminate\Database\Seeder;

class HealthConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HealthCondition::factory()->count(25)->create();
    }
}
