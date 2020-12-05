<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ShopService;
use App\Services\SearchService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ShopService::class);
        $this->app->singleton(SearchService::class);
    }
}
