<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use \Symfony\Component\HttpFoundation\Response as ResponseStatus;

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
     * Render the exception handling callbacks for the application.
     *
     * @return void
     */
    public function render($request, Throwable $e)
    {
            $statusCode = $e->getCode();
            
            switch ($statusCode) {
                case 400:
                    return response()->json_content(ResponseStatus::HTTP_BAD_REQUEST, 'Bad Request');
                    break;
                case 401:
                    return response()->json_content(ResponseStatus::HTTP_UNAUTHORIZED, 'Unauthorized');
                    break;
                case 403:
                    return response()->json_content(ResponseStatus::HTTP_FORBIDDEN, 'Forbidden');
                    break;
                case 404:
                    return response()->json_content(ResponseStatus::HTTP_NOT_FOUND, 'Not Found');
                    break;
                default :
                    return response()->json_content(ResponseStatus::HTTP_BAD_REQUEST, 'Bad Request');
                    break;
            }
    }
}
