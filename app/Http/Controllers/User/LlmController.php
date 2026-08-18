<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LlmController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:1|max:5000',
        ]);

        $server = $request->query('server', '192.168.1.94');

        $response = Http::timeout(30)
            ->post('http://' . $server . ':11434/api/generate', [
                // 'model' => 'mistral:7b',
                // 'model' => 'qwen2.5:3b',
                // 'model' => 'llama2:7b',
                // 'model' => 'phi3:mini',
                // 'model' => 'llama3.2:3b',
                'model' => 'ifioravanti/mistral-grammar-checker:latest',
                // 'prompt' => $request->text,
                // 'prompt' => "Correct spelling and grammar. Do not rewrite. Do not add content. Return corrected text only.\n\n" . $request->text,
                'prompt' => "You are a spell and grammar checker. Return only the corrected text with no explanation.\n\n" . $request->text,
                'stream' => false,
            ]);

        logger()->info('OLLAMA RAW', $response->json());

        // return response()->json([
        //     'corrected' => $response->json('response'),
        // ]);

        $corrected = $response->json('response');

        return response($corrected, 200)
            ->header('Content-Type', 'text/plain');
    }
}
