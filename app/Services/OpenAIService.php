<?php

namespace App\Services;

use App\AI\ChatConsultant;

class OpenAIService
{
    protected $client;

    public function __construct(ChatConsultant $chatConsultant)
    {
        $this->client = $chatConsultant;
    }

    public function getResponse(string $prompt): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);

        return $response->choices[0]->message->content;
    }

    public function uploadFile(string $filePath): string
    {
        $response = $this->client->files()->upload([
            'file' => fopen($filePath, 'r'),
        ]);

        return $response->id;
    }

    public function sendMessage(string $message)
    {
        $response = $this->client->send($message);

        return $response;
    }

    public function getMessages()
    {
        $response = $this->client->messages();

        return $response;
    }
}

