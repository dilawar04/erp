<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //TODO:: Dev
        error_reporting(E_ERROR | E_STRICT | E_PARSE);
        if(env('APP_QUERY_LOG')){
            \DB::enableQueryLog();
        }
        //Paginator::useBootstrap();
        \Schema::defaultStringLength(191);
    }
}
