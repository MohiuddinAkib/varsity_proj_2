<?php

namespace App\Providers;

use App\Contract\ICowService;
use App\Contract\IFarmService;
use App\Contract\IPostService;
use App\Services\CowService;
use App\Services\FarmService;
use App\Services\PostService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ICowService::class, CowService::class);
        $this->app->bind(IFarmService::class, FarmService::class);
        $this->app->bind(IPostService::class, PostService::class);
    }
}
