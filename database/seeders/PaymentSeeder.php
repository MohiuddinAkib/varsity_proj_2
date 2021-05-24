<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::role("employee")
            ->get()
            ->each(function (User $user) {
                Payment::factory()
                    ->count(20)
                    ->create([
                        "worker_id" => $user->id
                    ]);
            });
    }
}
