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
     * @return Response
     */

    public function boot()
    {
        Response::macro('json_content', function (int $status, string $message, int $response_code) {
            return response()->json([
                'code' => $status,
                'message' => $message
            ], $response_code);
        });
    }
}
