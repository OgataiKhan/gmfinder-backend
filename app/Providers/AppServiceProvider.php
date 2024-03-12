<?php

namespace App\Providers;

use Braintree\Gateway;
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
                    'merchantId'=>'x836p3xfjx89884d',
                    'publicKey'=>'7t3x7gb38jv742nx',
                    'privateKey'=>'7dffd5aa8bca672b06d5763c1d0e3a48',
                ]
            );
        });
        Paginator::useBootstrapFive();
    }
}
