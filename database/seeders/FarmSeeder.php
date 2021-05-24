<?php

namespace Database\Seeders;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Database\Seeder;

class FarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Farm::all()
            ->each(function (Farm $farm) {
                $localadmin = User::role("localadmin")->whereNull("farm_id")->first();

                if ($localadmin) {
                    $localadmin->update([
                        "farm_id" => $farm->id
                    ]);

                    $farm->update([
                        "ladmin_id" => $localadmin->id
                    ]);
                }

            });
    }
}
