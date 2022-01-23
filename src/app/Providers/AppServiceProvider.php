<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PostSpreadsheet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('PostSpreadsheet', \App\Services\PostSpreadsheet::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
