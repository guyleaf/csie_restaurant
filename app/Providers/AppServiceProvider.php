<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ShopService;
use App\Services\SearchService;
use App\Services\CustomerService;
use App\Services\MemberService;
use App\Services\ProductService;
use App\Services\OrderService;

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
        $this->app->singleton(CustomerService::class);
        $this->app->singleton(MemberService::class);
        $this->app->singleton(ProductService::class);
        $this->app->singleton(OrderService::class);
    }
}
