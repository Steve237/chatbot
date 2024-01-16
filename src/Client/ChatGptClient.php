<?php

namespace App\Client;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ChatGptClient
{
    public function generateResponse(string $question): ResponseInterface
    {
        $client = HttpClient::create();

        return $client->request('POST', 'https://api.openai.com/v1/chat/completions', [

            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $_ENV['CHAT_GPT'],
            ],
            'json' => [
                'model' => "gpt-4",
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $question,
                    ]
                ],
            ]
        ]);
    }
}