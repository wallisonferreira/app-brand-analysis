<?php

namespace App\AI;

use \Illuminate\Support\Facades\Http;

class Chat
{
    protected array $messages = [];

    public function systemMessage(string $message): static
    {
        $this->messages[] = [
            'role' => 'system',
            'content' => $message
        ];

        return $this;
    }

    public function send(string $message): ?string
    {
        dd($message);
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        $response = Http::withToken(config('services.openai.secret'))->post('https://api.openai.com/v1/chat/completions', [
            "model" => "gpt-4o-mini",
            "messages" => $this->messages
        ])->json('choices.0.message.content');

        dd($response);

        if ($response) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response
            ];
        }

        return $response;
    }

    public function reply(string $message): ?string
    {
        return $this->send($message);
    }

    public function messages()
    {
        return $this->messages;
    }
}
