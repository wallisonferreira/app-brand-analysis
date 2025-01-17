<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenAIController;
use Illuminate\Support\Str;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/openai-response', [OpenAIController::class, 'getResponse']);
    Route::post('/upload-file', [OpenAIController::class, 'uploadFile']);
    Route::post('/send-message', [OpenAIController::class, 'sendMessage']);
    Route::post('/process-csv', [OpenAIController::class, 'processCsv']);
    Route::get('/get-messages', [OpenAIController::class, 'getMessages']);
});
