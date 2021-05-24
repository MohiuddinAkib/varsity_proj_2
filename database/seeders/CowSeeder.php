<?php

namespace Database\Seeders;

use App\Models\Cow;
use Illuminate\Database\Seeder;

class CowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cow::factory()
            ->count(100)
            ->create();
    }
}
