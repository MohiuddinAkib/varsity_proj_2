<?php

namespace App\Providers;

use App\Models\Farm;
use App\Policies\FarmPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Farm::class => FarmPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("update-farm-local-admin", [FarmPolicy::class, "updateLocalAdmin"]);
        Gate::define("create-farm-post", [FarmPolicy::class, "createPost"]);
    }
}
