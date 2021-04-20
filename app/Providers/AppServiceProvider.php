<?php

namespace App\Providers;

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
        //Schema::defaultStringLength(191);
        //CustomValidation::init();
        view()->composer('layouts.homelayout.main_header', 'App\Http\Controllers\Frontend\PartialsController@navbar');
        view()->composer('layouts.homelayout.front_footer', 'App\Http\Controllers\Frontend\PartialsController@footer');
        view()->composer('layouts.homelayout.header', 'App\Http\Controllers\Frontend\PartialsController@header');
    }
}
