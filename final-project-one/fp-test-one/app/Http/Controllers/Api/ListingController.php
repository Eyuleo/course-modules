<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ListingController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }

    public function store(Request $request): JsonResponse
    {
        return $this->error('Not implemented', 501);
    }
}
