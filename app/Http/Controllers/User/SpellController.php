<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\SpellCheckService;

class SpellController extends Controller
{
    public function chat(SpellCheckService $spell)
    {
        $text = request('text');

        $prompt = request('prompt', 'basic');


        $corrected = $spell->check($text, $prompt);

        // return response()->json([
        //     'original' => $text,
        //     'corrected' => $corrected
        // ]);

        // @dump($corrected);

        return $corrected;
    }
}