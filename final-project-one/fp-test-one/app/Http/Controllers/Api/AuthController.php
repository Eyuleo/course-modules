<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function login(Request $request): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }
}
