<?php

namespace Tests;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $farmService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->farmService = $this->app->make('App\Contract\IFarmService');

        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        if (Role::whereName("superadmin")->doesntExist())
            Artisan::call("permission:create-role superadmin");
        if (Role::whereName("localadmin")->doesntExist())
            Artisan::call("permission:create-role localadmin");
        if (Role::whereName("employee")->doesntExist())
            Artisan::call("permission:create-role employee");
    }
}
