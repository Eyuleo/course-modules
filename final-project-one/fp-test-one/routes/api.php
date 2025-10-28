<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (v1)
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    // Health check for API
    Route::get('/health', fn () => ['status' => 'ok', 'version' => 'v1']);

    // Auth
    Route::post('/auth/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    // Listings
    Route::get('/listings', [\App\Http\Controllers\Api\ListingController::class, 'index']);
    Route::post('/listings', [\App\Http\Controllers\Api\ListingController::class, 'store'])->middleware('auth:sanctum');

    // Orders
    Route::post('/orders', [\App\Http\Controllers\Api\OrderController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/orders/{id}/fund', [\App\Http\Controllers\Api\OrderController::class, 'fund'])->middleware('auth:sanctum');
    Route::post('/orders/{id}/accept', [\App\Http\Controllers\Api\OrderController::class, 'accept'])->middleware('auth:sanctum');
    Route::post('/orders/{id}/deliver', [\App\Http\Controllers\Api\OrderController::class, 'deliver'])->middleware('auth:sanctum');
    Route::post('/orders/{id}/approve', [\App\Http\Controllers\Api\OrderController::class, 'approve'])->middleware('auth:sanctum');
    Route::post('/orders/{id}/cancel', [\App\Http\Controllers\Api\OrderController::class, 'cancel'])->middleware('auth:sanctum');

    // Messaging
    Route::get('/messages/threads/{context}/{id}', [\App\Http\Controllers\Api\MessagingController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/messages/threads/{context}/{id}', [\App\Http\Controllers\Api\MessagingController::class, 'store'])->middleware('auth:sanctum');

    // Reviews
    Route::post('/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'store'])->middleware('auth:sanctum');

    // Stripe webhook (public, validated internally)
    Route::post('/stripe/webhook', \App\Http\Controllers\Api\StripeWebhookController::class);
});
