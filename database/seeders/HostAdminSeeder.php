<?php

namespace Database\Seeders;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Database\Seeder;

class HostAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(20)
            ->hasFarms(2)
            ->create()
            ->each(function (User $user) {
                $user->assignRole("hostadmin");
            });
    }
}
