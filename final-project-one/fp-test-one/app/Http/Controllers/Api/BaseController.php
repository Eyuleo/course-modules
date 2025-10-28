<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseLaravelController;

class BaseController extends BaseLaravelController
{
    protected function success(array $data = [], int $status = 200, array $headers = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status, $headers);
    }

    protected function error(string $message, int $status = 400, array $errors = [], array $headers = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status, $headers);
    }
}
