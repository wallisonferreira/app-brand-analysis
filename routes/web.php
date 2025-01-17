<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenAIController;
use \Illuminate\Support\Facades\Http;
use App\AI\Chat;

Route::get('/openai', function () {
    return view('openai');
});

Route::post('/openai-response', [OpenAIController::class, 'getResponse']);
Route::post('/upload-file', [OpenAIController::class, 'uploadFile']);
Route::post('/send-message', [OpenAIController::class, 'sendMessage']);
Route::get('/get-messages', [OpenAIController::class, 'getMessages']);
Route::post('/process-csv', [OpenAIController::class, 'processCsv']);

route::get('/', function () {
    return view('welcome');
});
