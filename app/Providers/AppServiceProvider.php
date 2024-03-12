<?php

namespace App\Providers;

use Braintree\Gateway;

use Illuminate\Pagination\Paginator as Paginator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(Gateway::class, function($app){
            return new Gateway(
                [
                    'environment'=>'sandbox',
                    'merchantId'=>'mbjfc8s9gn3by8wg',
                    'publicKey'=>'czxmkxzz7dnj6s9d',
                    'privateKey'=>'886acf258d7c3e5b50974ab411db22d4',
                ]
            );
        });
        Paginator::useBootstrapFive();
    }
}
