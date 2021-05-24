<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        try {
//            DB::connection()->getPdo();
//            if (DB::connection()->getDatabaseName() && Schema::hasTable("roles")) {
//                if (Role::whereName("superadmin")->doesntExist())
//                    Artisan::call("permission:create-role superadmin");
//                if (Role::whereName("hostadmin")->doesntExist())
//                    Artisan::call("permission:create-role hostadmin");
//                if (Role::whereName("localadmin")->doesntExist())
//                    Artisan::call("permission:create-role localadmin");
//                if (Role::whereName("employee")->doesntExist())
//                    Artisan::call("permission:create-role employee");
//                if (Role::whereName("cleaner")->doesntExist())
//                    Artisan::call("permission:create-role cleaner");
//                if (Role::whereName("feeder")->doesntExist())
//                    Artisan::call("permission:create-role feeder");
//                if (Role::whereName("sweeper")->doesntExist())
//                    Artisan::call("permission:create-role sweeper");
//                if (Role::whereName("hay_cutter")->doesntExist())
//                    Artisan::call("permission:create-role hay_cutter");
//                if (Role::whereName("guard")->doesntExist())
//                    Artisan::call("permission:create-role guard");
//            }
//        } catch (\Doctrine\DBAL\Driver\PDO\Exception $e) {
//
//        }
    }
}
