<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        $this->renderable(function (HttpResponseException $e, $request) {
            if ($request->is('api/*')) {
                $response = $e->getResponse();
                $status = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : 400;
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], $status);
            }
        });
    }
}
