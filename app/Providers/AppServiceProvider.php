<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ShopService;

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
    }
}
