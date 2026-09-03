<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpellCheckService
{
    public function check(string $text, string $prompt = 'basic'): array|string
    {
        $endpoint   = config('services.azure_openai.endpoint');
        $deployment = config('services.azure_openai.deployment');
        $apiKey     = config('services.azure_openai.key');
        $version    = config('services.azure_openai.version');

        if ($prompt === 'eis') {
            $systemPrompt = file_get_contents(storage_path('app/private/ai.txt'));
        } else {
            $systemPrompt = 'Correct spelling and grammar mistakes only. Do not change the meaning or style of the text.';
        }

        $payload = [
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => "Review the following status note:\n" . $text],
            ],
            'temperature' => 0.1,
            'max_tokens'  => 1200,
        ];

        if ($prompt === 'eis') {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        $response = Http::withHeaders([
            'api-key'      => $apiKey,
            'Content-Type' => 'application/json',
        ])->post("$endpoint/openai/deployments/$deployment/chat/completions?api-version=$version", $payload);

        $content = $response->json('choices.0.message.content');

        if ($prompt === 'eis') {
            return json_decode($content, true) ?? [];
        }

        return $content;
    }
}
