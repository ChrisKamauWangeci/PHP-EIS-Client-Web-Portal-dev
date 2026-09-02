<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpellCheckService
{
    public function check(string $text, string $prompt = 'basic'): string
    {
        $endpoint = config('services.azure_openai.endpoint');
        $deployment = config('services.azure_openai.deployment');
        $apiKey = config('services.azure_openai.key');
        $version = config('services.azure_openai.version');

        // dd("Endpoint: $endpoint, Deployment: $deployment, Version: $version, API Key: $apiKey");

        // Return the same text with spelling corrected only. Do not rewrite or add words.

        if ($prompt === 'eis') {
            $systemPrompt = file_get_contents(
                storage_path('app/private/ai.txt')
            );
        } else {
            $systemPrompt = 'Correct spelling and grammar mistakes only. Do not change the meaning or style of the text.';
        }

        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post("$endpoint/openai/deployments/$deployment/chat/completions?api-version=$version", [
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt,
                ],
                [
                    'role' => 'user',
                    'content' => $text,
                ],
            ],
            'temperature' => 0,
            'max_tokens' => 500,
        ]);

        dd($response->json());

        return $response->json('choices.0.message.content');
    }
}
