<?php

namespace Database\Seeders;

use App\Contract\IUserRole;
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
        if (Role::whereName(IUserRole::SUPER_ADMIN)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::SUPER_ADMIN);
        if (Role::whereName(IUserRole::HOST_ADMIN)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::HOST_ADMIN);
        if (Role::whereName(IUserRole::LOCAL_ADMIN)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::LOCAL_ADMIN);
        if (Role::whereName(IUserRole::EMPLOYEE)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::EMPLOYEE);
        if (Role::whereName(IUserRole::CLEANER)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::CLEANER);
        if (Role::whereName(IUserRole::FEEDER)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::FEEDER);
        if (Role::whereName(IUserRole::SWEEPER)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::SWEEPER);
        if (Role::whereName(IUserRole::HAY_CUTTER)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::HAY_CUTTER);
        if (Role::whereName(IUserRole::GUARD)->doesntExist())
            Artisan::call("permission:create-role " . IUserRole::GUARD);
    }
}
