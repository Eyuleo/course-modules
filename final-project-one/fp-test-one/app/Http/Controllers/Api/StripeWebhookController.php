<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StripeWebhookController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        return $this->success(['received' => true], 200);
    }
}
