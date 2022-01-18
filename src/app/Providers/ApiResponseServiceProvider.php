<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
/*
     public function boot()
    {
        Response::macro('json_content', function ($status, $message) {
            return response()->json([
                'code' => $status,
                'message' => $message,
            ], $status);
        });
    }
*/

}
