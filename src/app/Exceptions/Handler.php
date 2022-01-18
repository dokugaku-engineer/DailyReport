<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
//use \Symfony\Component\HttpFoundation\Response as ResponseStatus;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
/*
    private function apiErrorResponse($exception)
    {
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();

            switch ($statusCode) {
                case 400:
                    return response()->json_content(ResponseStatus::HTTP_BAD_REQUEST, 'Bad Request');
                case 401:
                    return response()->json_content(ResponseStatus::HTTP_UNAUTHORIZED, 'Unauthorized');
                case 403:
                    return response()->json_content(ResponseStatus::HTTP_FORBIDDEN, 'Forbidden');
                case 404:
                    return response()->json_content(ResponseStatus::HTTP_NOT_FOUND, 'Not Found');
            }
        }
    }
*/
}
