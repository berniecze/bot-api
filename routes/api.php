<?php

use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\ChatbotStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chatbots', [ChatbotController::class, 'index']);
    Route::post('/chatbots', [ChatbotController::class, 'store']);
    Route::get('/chatbots/{chatbot}/status', [ChatbotStatusController::class, 'streamStatus']);
}); 