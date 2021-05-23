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
        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName() && Schema::hasTable("roles")) {
                if (Role::whereName("superadmin")->doesntExist())
                    Artisan::call("permission:create-role superadmin");
                if (Role::whereName("localadmin")->doesntExist())
                    Artisan::call("permission:create-role localadmin");
                if (Role::whereName("employee")->doesntExist())
                    Artisan::call("permission:create-role employee");

                if (Role::whereName("cattle")->doesntExist())
                    Artisan::call("permission:create-role cattle");
                if (Role::whereName("dairy")->doesntExist())
                    Artisan::call("permission:create-role dairy");
                if (Role::whereName("fattening")->doesntExist())
                    Artisan::call("permission:create-role fattening");
            }
        } catch (\Doctrine\DBAL\Driver\PDO\Exception $e) {

        }
    }
}
