<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MessagingController extends BaseController
{
    public function index(string $context, int $id): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function store(Request $request, string $context, int $id): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }
}
