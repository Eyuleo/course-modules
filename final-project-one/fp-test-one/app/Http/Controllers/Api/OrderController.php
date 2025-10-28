<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseController
{
    public function store(Request $request): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function fund(Request $request, int $id): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function accept(Request $request, int $id): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function deliver(Request $request, int $id): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function approve(Request $request, int $id): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function cancel(Request $request, int $id): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }
}
