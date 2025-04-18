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

    $chat = new Chat();

    $response = $chat
        ->systemMessage('Você é uma assistente especializada em dar dicas e tirar dúvidas acerca de registro de marca.')
        ->send("Flikta é um bom nome para registro de marca no INPI?");

    $chat->reply('Perfeito! Podes me dar mais detalhes do serviço?');

    // dd($chat->messages());

    return view('welcome', [
        'response' => $chat->messages()
    ]);
});
