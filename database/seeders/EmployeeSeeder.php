<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app()->make(\Faker\Generator::class);

        User::factory()
            ->count(50)
            ->create()
            ->each(function (User $user) use ($faker) {
                $employee_roles = [$faker->randomElement(["cleaner", "feeder", "sweeper", "hay_cutter", "guard", "localadmin"])];
                $employee_roles += ["employee"];
                $user->assignRole($employee_roles);
            });


    }
}
