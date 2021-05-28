<?php

namespace App\Providers;

use App\Models\Cow;
use App\Models\Farm;
use App\Policies\CowRecordPolicy;
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
        Cow::class => CowRecordPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("create-farm-post", [FarmPolicy::class, "createPost"]);
        Gate::define("update-farm-local-admin", [FarmPolicy::class, "updateLocalAdmin"]);
    }
}
