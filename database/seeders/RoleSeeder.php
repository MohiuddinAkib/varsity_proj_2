<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::whereName("superadmin")->doesntExist())
            Artisan::call("permission:create-role superadmin");
        if (Role::whereName("hostadmin")->doesntExist())
            Artisan::call("permission:create-role hostadmin");
        if (Role::whereName("localadmin")->doesntExist())
            Artisan::call("permission:create-role localadmin");
        if (Role::whereName("employee")->doesntExist())
            Artisan::call("permission:create-role employee");
        if (Role::whereName("cleaner")->doesntExist())
            Artisan::call("permission:create-role cleaner");
        if (Role::whereName("feeder")->doesntExist())
            Artisan::call("permission:create-role feeder");
        if (Role::whereName("sweeper")->doesntExist())
            Artisan::call("permission:create-role sweeper");
        if (Role::whereName("hay_cutter")->doesntExist())
            Artisan::call("permission:create-role hay_cutter");
        if (Role::whereName("guard")->doesntExist())
            Artisan::call("permission:create-role guard");
    }
}
