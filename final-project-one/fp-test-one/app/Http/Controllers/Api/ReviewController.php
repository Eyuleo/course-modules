<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends BaseController
{
    public function store(Request $request): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }
}
