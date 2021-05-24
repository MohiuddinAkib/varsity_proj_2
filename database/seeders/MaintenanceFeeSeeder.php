<?php

namespace Database\Seeders;

use App\Models\MaintenanceFee;
use Illuminate\Database\Seeder;

class MaintenanceFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaintenanceFee::factory()
            ->count(20)
            ->create();
    }
}
